<?php


namespace app\commands;


use app\models\User;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

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
        $super = $auth->createRole('superAdmin');
        $super->description = 'Super admin (.!.)';
        $auth->add($super);

        $auth->addChild($super, $admin);
        $auth->addChild($super, $user_edit);
        $auth->addChild($super, $user_delete);
        $auth->addChild($super, $vote_create);

        echo 'Create super admin, matherFUCKER role ..!.. ..!.., YEAH, BABY!' . PHP_EOL;
        echo 'End script work' . PHP_EOL;
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
        if (!$model = User::getByUsername($username)) {
            throw new Exception('User not found');
        }
        return $model;
    }


}