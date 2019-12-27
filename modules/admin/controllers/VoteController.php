<?php

namespace app\modules\admin\controllers;

use app\models\Vote;
use Faker\Factory;
use Faker\Provider\ru_RU\Address;
use Faker\Provider\ru_RU\Internet;
use Faker\Provider\ru_RU\PhoneNumber;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class VoteController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['moderator']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add', 'add-range'],
                        'roles' => ['superuser']
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vote::find(),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        return $this->render('index', compact('dataProvider'));
    }

    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionAdd()
    {
        $faker = Factory::create('ru-RU');
        $status = [5, 10, 15, 99];

        try {
            $vote = new Vote();
            $vote->setAttributes([
                'email'         => $faker->freeEmail,
                'phone'         => $faker->phoneNumber,
                'age'           => mt_rand(1, 7),
                'rating'        => mt_rand(1, 10),
                'text'          => $faker->realText(mt_rand(20, 100)),
                'status'        => $status[mt_rand(0, 3)],
                'verify_token'  => \Yii::$app->security->generateRandomString(),
                'state'         => $faker->state,
                'city'          => $faker->city,
                'street'        => $faker->streetName,
                'home'          => '' . mt_rand(1, 100),
            ]);

            $data = [];

            for ($i = 0; $i < 50; $i++){
                $data[$i] = [
                    $faker->freeEmail,
                    $faker->e164PhoneNumber,
                    mt_rand(1, 7),
                    mt_rand(1, 10),
                    $faker->realText(mt_rand(20, 100)),
                    $status[mt_rand(0, 3)],
                    \Yii::$app->security->generateRandomString(),
                    $faker->state,
                    $faker->city,
                    $faker->streetName,
                    '' . mt_rand(1, 100),
                ];
            }

            \Yii::$app->db->createCommand()
                ->batchInsert('vote',
                    ['email', 'phone', 'age', 'rating', 'text', 'status', 'verify_token', 'state', 'city', 'street', 'home'],
                    $data)
                ->execute();

//            if ($vote->validate() && $vote->save()) {
//                return $this->redirect(['vote/index']);
//            }
        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $this->redirect(['vote/index']);
    }

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionAddRange()
    {
        $faker = Factory::create('ru-RU');
        $status = [5, 10, 15, 99];

        try {
            $data = [];

            for ($i = 0; $i < 50; $i++){
                $data[$i] = [
                    $faker->freeEmail,
                    $faker->e164PhoneNumber,
                    mt_rand(1, 7),
                    mt_rand(1, 10),
                    $faker->realText(mt_rand(20, 100)),
                    $status[mt_rand(0, 3)],
                    \Yii::$app->security->generateRandomString(),
                    $faker->state,
                    $faker->city,
                    $faker->streetName,
                    '' . mt_rand(1, 100),
                ];
            }

            \Yii::$app->db->createCommand()
                ->batchInsert('vote',
                    ['email', 'phone', 'age', 'rating', 'text', 'status', 'verify_token', 'state', 'city', 'street', 'home'],
                    $data)
                ->execute();

        } catch (\Exception $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $this->redirect(['vote/index']);
    }

    public function actionView(int $id)
    {
        return $this->render('view');

    }

    public function actionUpdate(int $id)
    {
        return $this->render('update');

    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function actionDelete(int $id)
    {
        // TODO: Fix bug with deleted lasted element
        if (\Yii::$app->request->isAjax) {
            $vote = Vote::findOne(['id' => $id]);
            if ($vote) {
                $transaction = Vote::getDb()->beginTransaction();
                try {
                    $vote->delete();
                    $transaction->commit();
                    \Yii::$app->session->setFlash('vote', [
                        'header' => 'Success',
                        'message' => 'Success deleted select vote from database',
                        'icon' => 'fas fa-check',
                        'type' => 'success'
                    ]);
                    return true;
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return false;
            }
        }

        return false;

    }

    public function actionSend(int $id)
    {

    }
}
