<?php
namespace console\services;

use Yii;
/**
 * class TestServices
 * @package console\services
*/
class TestService
{
    const DOMAIN = 'http://api.local/';

    public function connectApiUrl($url, $method, $data = [])
    {
        $connection = curl_init();

        if ($method === 'post') {
            curl_setopt($connection, CURLOPT_POST, 1);
            curl_setopt($connection, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($connection, CURLOPT_URL, self::DOMAIN .  $url );
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, true );
        $res = curl_exec($connection);
        curl_close($connection);

        return $res;
    }

    public function getParamsQuery($url, $method = 'get', $params = [], $measureTime = false)
    {
        $timeStart = microtime(true);
        $getParams = '';

        if (!empty($params) && $method === 'get') {
            $_GET = $params;
        } elseif (!empty($params) && $method === 'post') {
            $_POST = $params;
        }

        $res = $this->connectApiUrl($url . $getParams, $method, $params);
        $timeFinish = microtime(true);

        if ($measureTime) {
            return ($timeFinish - $timeStart);
        }

        return $res;
    }
}