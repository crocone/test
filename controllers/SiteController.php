<?php

namespace app\controllers;

use app\jobs\CheckBotJob;
use app\models\Code;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{

    public function actionIndex($code = null)
    {
        return $this->render('/index', ['error' => false]);
    }

}
