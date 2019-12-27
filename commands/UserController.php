<?php


namespace app\commands;


use app\modules\admin\models\User;
use yii\console\Controller;

class UserController extends Controller
{

    /**
     * Show all users in system
     */
    public function actionShowAll(): void
    {
        $this->stdout('Show all users in system:' . PHP_EOL);
        $users = User::find()
            ->select(['user.id', 'user.username', 'user.email', 'CONCAT(user.first_name, \' \', user.last_name) AS name', 'auth_assignment.item_name AS role'])
            ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
            ->asArray()
            ->all();
        $rows = [];
        for ($i = 0; $i < count($users); $i ++) {
            $rows[$i] = [$users[$i]['id'], $users[$i]['username'], $users[$i]['email'], $users[$i]['name'], $users[$i]['role']];
        }

        $table = new \yii\console\widgets\Table();
        $table->setHeaders(['ID', 'Username', 'Email', 'Name', 'Role']);
        $table->setRows($rows);
        $this->stdout($table->run());
    }

    /**
     * Create new user in system
     */
    public function actionCreate()
    {
        $user = $this->getUserInfo();
        $this->createUser($user);
        return;
    }

    /**
     * Create new super user account for control all system
     *
     * @throws \Exception
     */
    public function actionSuperuser()
    {
        if (!RbacController::isLoaded()) {
            if (!RbacController::hasRole('superuser')) {
                return;
            }
        }

        $user_info = $this->getUserInfo(true);

        if ($user_info === []) {
            $this->stdout('Cancel operation on User' . PHP_EOL);
            return;
        }

        $user = $this->createUser($user_info);

        // Set role permissions for superuser
        $manager = \Yii::$app->getAuthManager();
        $role = $manager->getRole('superuser');
        $manager->assign($role, $user->getId());

    }

    /**
     * Remove selected user from system
     */
    public function actionRemove()
    {
        $username = $this->prompt('Enter username: ', ['required' => true]);

        // check username
        $user = User::findByUsername($username);
        if ($user === null) {
            $this->stdout('ERROR!' . PHP_EOL);
            $this->stdout('No records found for the username entered. Please check you entered data and try again');
            return;
        }
        return;
    }

    /**
     * Clear all user record in database
     */
    public function actionClearAll(): void
    {
        $this->stdout('DANGER COMMAND!' . PHP_EOL);
        $this->stdout('Clear all data on user table' . PHP_EOL);

        // check count user records in database
        if (User::find()->count() == 0) {
            $this->stdout('In table user not found records');
            return;
        }

        $response = $this->prompt('You really want delete all info in user table? [yes/no]: ', ['required' => true]);

        // check response from user
        if (strtolower($response) === 'yes' || strtolower($response) === 'y') {
            // disconnect all roles from users
            $this->stdout('Disconnect all roles from users');
            $manager = \Yii::$app->getAuthManager();
            $manager->removeAllAssignments();
            // delete all data
            User::deleteAll();
            $this->stdout('All data deleted!');
            return;
        } else if (strtolower($response) === 'no' || strtolower($response) === 'n') {
            $this->stdout('Cancel operation!');
            return;
        } else {
            $this->stdout('The answer is not recognized! Please try again.');
            return;
        }
    }

    /**
     * Gets information from user for creation new record
     *
     * @param bool $superuser
     * @return array
     */
    private function getUserInfo(bool $superuser = false): array
    {
        $result = [];

        begin:
        $this->stdout('This command create new User account!' . PHP_EOL);
        $this->stdout('This command can use only administrator or programmer!' . PHP_EOL);

        $result['username'] = $this->prompt('Username: ', ['required' => true]);

        pass_enter:
        $result['password'] = $this->prompt('Password: ', ['required' => true]);

        // check password
        if (!$this->checkPassword($result['password'])) {
            $response = $this->prompt('The password used is too simple, do you really want to use it? [yes/no]: ', ['required' => true]);
            if (strtolower($response) === 'no' || strtolower($response) === 'n')
                goto pass_enter;
            if (strtolower($response) === 'yes' || strtolower($response) === 'y') {
                goto next;
            } else {
                $response = $this->prompt('The answer is not recognized, do you want to start from the beginning? [yes/no]:', ['required' => true]);
                if (strtolower($response) === 'no' || strtolower($response) === 'n')
                    return [];
                if (strtolower($response) === 'yes' || strtolower($response) === 'y') {
                    goto begin;
                }
            }
        }

        next:
        if (!$superuser) {
            $result['email'] = $this->prompt('Email: ', ['required' => true]);
            $result['first_name'] = $this->prompt('First name: ', ['required' => true]);
            $result['last_name'] = $this->prompt('Last name: ', ['required' => true]);
        } else {
            $result['email'] = \Yii::$app->params['adminEmail'];
            $result['first_name'] = 'Admin';
            $result['last_name'] = 'Super User';
        }

        return $result;
    }

    /**
     * Create new user in system
     *
     * @param array $user_info
     * @return User
     */
    private function createUser(array $user_info): User
    {
        // create user
        $transaction = User::getDb()->beginTransaction();
        try {
            $user = new User();
            $user->setAttribute('username', $user_info['username']);
            $user->setPassword($user_info['password']);
            $user->setAttribute('email', $user_info['email']);
            $user->setAttribute('first_name', $user_info['first_name']);
            $user->setAttribute('last_name', $user_info['last_name']);
            $user->setAttribute('is_blocked', User::UNBLOCKED);
            $user->setAttribute('access_token', \Yii::$app->security->generateRandomString());
            $user->setAttribute('verify_token', null);

            if ($user->validate() && $user->save()) {
                $transaction->commit();

                $this->stdout('Success create superuser account.' . PHP_EOL);
                $this->stdout('Use this date for enter to admin panel.' . PHP_EOL);
                $this->stdout('LOGIN: ' . $user->username . PHP_EOL . 'PASSWORD: ' . $user_info['password'] . PHP_EOL);
                return $user;
            } else {
                $this->stdout('WARNING!' . PHP_EOL);
                $this->stdout('Validation error! Please check all information' . PHP_EOL);
                return null;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->stdout('ERROR!' . PHP_EOL);
            $this->stdout('Please check error information' . PHP_EOL);
            $this->stdout($e->getMessage() . PHP_EOL);
            return null;
        }
    }

    /**
     * Checking password
     *
     * @param string $password
     * @return bool
     */
    private function checkPassword(string $password): bool
    {
        $check = true;

        // check length password
        if (strlen($password) <= 8) {
            $this->stdout('PASSWORD WARNING: Length password has less 8' . PHP_EOL);
            $check = false;
        }

        // check on letters and numbers in password
        if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])[0-9a-zA-Z]{8,}$/', $password)) {
            $this->stdout('PASSWORD WARNING: The password should preferably contain letters and numbers.' . PHP_EOL);
            $check = false;
        }

        return $check;
    }

}