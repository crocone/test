<?php

namespace app\commands;

use app\models\Code;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;

class CodeController extends Controller
{
    public function actionGenerate()
    {
        $codeModel = new Code();
        try {
            $codeModel->generateCode();
        } catch (Exception $e) {
            return $this->stdout('Произошла неизвестная ошибка', Console::BG_RED);
        }
        if (!$codeModel->save()) {
            return $this->stdout('Произошла неизвестная ошибка', Console::BG_RED);
        }

        return $this->stdout($codeModel->code, Console::BOLD);
    }

    public function actionRetrieve($id)
    {
        $codeModel = Code::findOne($id);

        if (is_null($codeModel)) {
            $this->stdout('Код не найден', Console::BG_RED);
        }

        return $this->stdout($codeModel->code, Console::BOLD);
    }

    public function actionYesterdayReport()
    {
        $from = date('Y-m-d 00:00:00', strtotime('yesterday'));
        $to = date('Y-m-d 23:59:59', strtotime('yesterday'));

        $fileName = \Yii::getAlias('@webroot') . '/reports/' . date('d.m.Y', strtotime('yesterday')) . '.txt';
        $fh = fopen($fileName, "wb") or die("Couldn't create file");

        $codes = Code::find()
            ->select('code')
            ->where(['>=', 'created_at', $from])
            ->andWhere(['<=', 'created_at', $to])
            ->all();
        if (count($codes) === 0) {
            $dataText = "Записей нет";
        } else {
            $dataText = "";
            foreach ($codes as $code) {
                $dataText .= $code->code . PHP_EOL;
            }
        }
        echo PHP_EOL;
        fwrite($fh, $dataText) or die("Couldn't write to file.");
    }

}
