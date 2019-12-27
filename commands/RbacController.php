<?php


namespace app\commands;


use app\modules\admin\models\User;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // clear all records
        $auth->removeAll();

        // create base rules
        $dashboard = $auth->createPermission('admin_panel');
        $dashboard->description = 'Admin panel';
        $auth->add($dashboard);

        $vote = $auth->createPermission('vote');
        $vote->description = 'Can vote on site';
        $auth->add($vote);

        $vote_create = $auth->createPermission('vote_create');
        $vote_create->description = 'Can create new vote on admin panel';
        $auth->add($vote_create);

        $vote_view = $auth->createPermission('vote_view');
        $vote_view->description = 'Can view vote on admin panel';
        $auth->add($vote_view);

        $vote_edit = $auth->createPermission('vote_edit');
        $vote_edit->description = 'Can edit votes in admin panel';
        $auth->add($vote_edit);

        $vote_delete = $auth->createPermission('vote_delete');
        $vote_delete->description = 'Can delete votes in admin panel';
        $auth->add($vote_delete);

        $user_create = $auth->createPermission('user_create');
        $user_create->description = 'Can create new user';
        $auth->add($user_create);

        $user_view = $auth->createPermission('user_view');
        $user_view->description = 'Can view info on user';
        $auth->add($user_view);

        $user_edit = $auth->createPermission('user_edit');
        $user_edit->description = 'Can edit user';
        $auth->add($user_edit);

        $user_delete = $auth->createPermission('user_delete');
        $user_delete->description = 'Can delete user';
        $auth->add($user_delete);

        $send_email = $auth->createPermission('send_email');
        $send_email->description = 'Can send email on user email in vote';
        $auth->add($send_email);

        $create_respond_email_template = $auth->createPermission('create_respond_email_template');
        $create_respond_email_template->description = 'Can create template for resend email';
        $auth->add($create_respond_email_template);

        $create_email_template = $auth->createPermission('create_email_template');
        $create_email_template->description = 'Can create template for email';
        $auth->add($create_email_template);

        echo 'Create all permissions' . PHP_EOL;

        // create user roles
        $user = $auth->createRole('user');
        $user->description = 'Base user for vote';
        $auth->add($user);

        // set user permissions
        $auth->addChild($user, $vote);

        echo 'Create user role' . PHP_EOL;


        // create moderator role
        $moder = $auth->createRole('moderator');
        $moder->description = 'Moderator for control votes';
        $auth->add($moder);

        // set moderator permissions
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);
        $auth->addChild($moder, $vote_view);
        $auth->addChild($moder, $send_email);

        echo 'Create moderator role' . PHP_EOL;


        // create admin role
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);

        // set admin permissions
        $auth->addChild($admin, $moder);
        $auth->addChild($admin, $vote_edit);
        $auth->addChild($admin, $vote_delete);
        $auth->addChild($admin, $user_view);
        $auth->addChild($admin, $user_create);
        $auth->addChild($admin, $create_respond_email_template);
        $auth->addChild($admin, $create_email_template);

        echo 'Create administrator role' . PHP_EOL;


        // ! create super admin user for programmers
        $super = $auth->createRole('superuser');
        $super->description = 'Super admin (.!.)';
        $auth->add($super);

        $auth->addChild($super, $admin);
        $auth->addChild($super, $user_edit);
        $auth->addChild($super, $user_delete);
        $auth->addChild($super, $vote_create);

        echo 'Create super admin, matherFUCKER role ..!.. ..!.., YEAH, BABY!' . PHP_EOL;
        echo 'End script work' . PHP_EOL;
    }

    public function actionCreatePermission()
    {
        $manager = Yii::$app->getAuthManager();

        $this->stdout("Welcome to created permission in RBAC system\n");

        enter_permission_name:
        $permission_name = $this->prompt("Please enter new permission name: ", ['required' => true]);

        if (empty($permission_name)) {
            $this->stdout("ERROR!\nPermission name cannot be empty!\nCancel operation!\n");
            return ExitCode::CANTCREAT;
        }

        if ($manager->getPermission($permission_name) !== null) {
            $toRewrite = $this->stdout("WARNING!\nPermission with this name all ready exist!\nYou can change permission name? [yes/no]: ");
            $toRewrite = strtolower($toRewrite);
            if ($toRewrite === 'yes' || $toRewrite === 'y') {
                goto enter_permission_name;
            } else if ($toRewrite === 'no' || $toRewrite === 'n') {
                $this->stdout('OPERATION CANCEL BY USER!');
                return ExitCode::CANTCREAT;
            } else {
                $this->stdout("ERROR!\nEntered response from user cannot be recognized!\nCancel operation and exit");
                return ExitCode::CANTCREAT;
            }
        }

        $description = $this->prompt("Enter description for permission (can be empty): ");

        $permission = $manager->createPermission($permission_name);
        $permission->description = empty($description) ? '' : $description;
        $manager->add($permission);

        $this->stdout("Success created new permission [" . $permission_name . "]");
        return ExitCode::OK;
    }

    public function actionAssign()
    {

        $this->stdout('Welcome to RBAC assign role to user!' . PHP_EOL . 'You need enter username and select role for him.' . PHP_EOL);
        $username = $this->prompt('Username: ', ['required' => true]);
        try {
            $user = $this->findModel($username);
            $role_name = $this->select('Role:', ArrayHelper::map(
                Yii::$app->authManager->getRoles(),
                'name',
                'description'
            ));
            $manager = Yii::$app->getAuthManager();
            $role = $manager->getRole($role_name);
            $manager->assign($role, $user->getId());
            $this->stdout('Done!' . PHP_EOL);
        } catch (Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
            return ExitCode::DATAERR;
        } catch (\Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
            return ExitCode::DATAERR;
        }

        return ExitCode::OK;
    }

    public function actionPermissionToRole()
    {
        $this->stdout("Welcome in assign system permission to role\n");

        $manager = Yii::$app->getAuthManager();

        $permission_name = $this->select('Select permission: ', ArrayHelper::map(
            $manager->getPermissions(),
            'name',
            'description'
        ));
        $role_name = $this->select('Select role to assign: ', ArrayHelper::map(
            $manager->getRoles(),
            'name',
            'description'
        ));

        $permission = $manager->getPermission($permission_name);
        $role = $manager->getRole($role_name);

        $manager->addChild($role, $permission);

        $this->stdout("Success added new permission [" . $permission_name . "] to select role [" . $role_name . "]");
        return ExitCode::OK;
    }

    public function actionShowAllPermission()
    {
        $manager = Yii::$app->getAuthManager();
        $permissions = $manager->getPermissions();
        $index = 0;
        $rows = [];

        foreach ($permissions as $permission) {
            $rows[$index++] = [$permission->name];
        }

        $table = new Table();
        $table->setHeaders(['PERMISSION NAME'])
            ->setRows($rows);
        $this->stdout($table->run());
    }

    /**
     * Show all roles in RBAC system
     */
    public function actionShowAllRoles(): void
    {
        $manager = Yii::$app->getAuthManager();
        $roles = $manager->getRoles();
        $rows = [];
        $index = 0;
        foreach ($roles as $role) {
            $rows[$index++] = [$role->name];
        }

        $table = new Table();
        $table->setHeaders(['Name'])
            ->setRows($rows);
        $this->stdout($table->run());
    }

    public static function isLoaded(): bool
    {
        $manager = \Yii::$app->getAuthManager();
        if (count($manager->getRoles()) == 0) {
            Console::stdout('Not found Roles in RBAC system' . PHP_EOL);
            Console::stdout('Please start command: yii rbac/init' . PHP_EOL);
            return false;
        }
        return true;
    }

    public static function hasRole(string $role): bool
    {
        if (\Yii::$app->getAuthManager()->getRole($role) === null) {
            Console::stdout('Not found ' . $role . ' Role in RBAC system' . PHP_EOL);
            Console::stdout('Please start command: yii rbac/init' . PHP_EOL);
            return false;
        }
        return true;
    }

    public function actionClear()
    {

        $response = $this->prompt('You really want delete all RBAC records? [yes/no]: ', ['required' => true]);
        if (strtolower($response) === 'yes' || strtolower($response) === 'y') {
            Yii::$app->getAuthManager()->removeAll();
            $this->stdout('Removed success!');
            return;
        } else if (strtolower($response) === 'no' || strtolower($response) === 'n') {
            $this->stdout('Cancel operation!');
            return;
        } else {
            $this->stdout('Invalid input!');
            $this->stdout('Cancel operation!');
            return;
        }
    }

    public function actionRevoke()
    {
        $username = $this->prompt('Username: ', ['required' => true]);
        try {
            $user = $this->findModel($username);
            $role_name = $this->select('Role:', ArrayHelper::merge(
                ['all' => 'All Roles'],
                ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user->id), 'name', 'description'))
            );
            $manager = Yii::$app->getAuthManager();
            if ($role_name == 'all') {
                $manager->revokeAll($user->getId());
            } else {
                $role = $manager->getRole($role_name);

            }
        } catch (Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
            return ExitCode::DATAERR;
        } catch (\Exception $e) {
            $this->stdout($e->getMessage() . PHP_EOL);
            return ExitCode::DATAERR;
        }

        return ExitCode::OK;
    }

    /**
     * @param $username
     * @return User|null
     * @throws Exception
     */
    private function findModel($username)
    {
        if (!$model = User::findByUsername($username)) {
            throw new Exception('User not found');
        }
        return $model;
    }


}