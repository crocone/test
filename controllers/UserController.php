<?php

namespace app\controllers;

use app\models\User;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use Yii;
use yii\web\Response;

class UserController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors(); // TODO: Change the autogenerated stub

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => '*',
                'Access-Control-Request-Method' => ['POST'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
            ],
        ];


        return $behaviors;
    }

    public function actionLogin()
    {
        $username = Yii::$app->request->post('username', false);
        $password = Yii::$app->request->post('password', false);

        if (!$username || !$password) {
            return ['result' => 'error', 'message' => 'Переданы неверные параметры'];
        }

        $model = User::findOne(["username" => $username]);
        if (empty($model)) {
            return ['result' => 'error', 'message' => 'Пользователь не найден'];
        }
        if ($model->validatePassword($password)) {
            $model->last_login = Yii::$app->formatter->asTimestamp(date_create());
            $model->save(false);
            return ['result' => 'success', 'access_token' => $model->access_token];
        } else {
            throw new Yii\web\ForbiddenHttpException();
        }
    }

}