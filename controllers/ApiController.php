<?php

namespace app\controllers;


use app\models\Code;
use app\models\User;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    /**
     * @return array
     */

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'only' => ['generate', 'retrieve'],
            'class' => HttpBasicAuth::class,
            'auth' => [$this, 'auth']
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['generate', 'retrieve'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ],
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        if (empty($username) || empty($password)) {
            return null;
        }
        $user = User::findByUsername($username);

        if ($user && \Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            return $user;
        }

        return null;
    }

    public function actionGenerate()
    {
        $codeModel = new Code();
        try {
            $codeModel->generateCode();
        } catch (Exception $e) {
            return ['result' => 'error', 'message' => 'Произошла неизвестная ошибка'];
        }
        if (!$codeModel->save()) {
            return ['result' => 'error', 'message' => 'Произошла неизвестная ошибка'];
        }

        return [
            'result' => 'success',
            'code' => $codeModel->code
        ];
    }

    public function actionRetrieve($id)
    {
        $codeModel = Code::findOne($id);

        if (is_null($codeModel)) {
            return ['result' => 'error', 'message' => 'Код не найден'];
        }

        return [
            'result' => 'success',
            'code' => $codeModel->code
        ];
    }
}