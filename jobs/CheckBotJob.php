<?php

namespace app\jobs;

use app\models\Visits;
use yii\base\BaseObject;
use yii\base\ErrorException;
use yii\db\Exception;

class CheckBotJob extends BaseObject implements \yii\queue\JobInterface
{
    public $linkId;
    public $userAgent;
    public $date;

    /**
     * @throws ErrorException
     */
    public function execute($queue)
    {
        $check = $this->checkIsBot($this->userAgent);
        if ($check) {
            $visit = Visits::findOne(['url' => $this->linkId, 'date' => $this->date]);
            if (is_null($visit)) {
                $visit = new Visits();
                $visit->url = $this->linkId;
                $visit->date = $this->date;
                $visit->count = 1;
            } else {
                $visit->count += 1;
            }

            if (!$visit->save(true)) {
                throw new Exception('Ошибка при сохранении посещения в базу');
            }
        }

        return true;
    }

    /**
     * @param $userAgent
     * @return bool
     */
    private function checkIsBot($userAgent)
    {
        $url = sprintf("%s?%s", 'https://qnits.net/api/checkUserAgent?userAgent=', $userAgent);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $resp = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $resp['isBot'];
    }
}