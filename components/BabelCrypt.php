<?php

namespace app\components;

use PHPUnit\Framework\Exception;
use Yii;
use yii\log\Logger;
use yii\base\Behavior;

class BabelCrypt extends Behavior
{
    const METHOD = 'des';

    const KEY = 'BabelTime';

    const IV = '32210967';

    const httpSecurityKey = 'grl3afaf8aflf21034e1efeio';

    static function encryptNumber($pid, $method = self::METHOD, $key = self::KEY, $iv = self::IV)
    {

        $pid = intval ( $pid );
        $data = '';
        while ( $pid )
        {
            $char = $pid % 256;
            $data = chr ( $char ) . $data;
            $pid = intval ( ($pid - $char) / 256 );
        }
        $data = self::encrypt ( $data, true, $method, $key, $iv );
        return bin2hex ( $data );
    }

    static function decryptNumber($data, $method = self::METHOD, $key = self::KEY, $iv = self::IV)
    {

        $data = pack ( 'H' . strlen ( $data ), $data );
        $data = self::decrypt ( $data, true, $method, $key, $iv );
        if (false === $data)
        {
            return false;
        }

        $pid = 0;
        for($counter = 0; $counter < strlen ( $data ); $counter ++)
        {
            $pid <<= 8;
            $pid += ord ( $data [$counter] );
        }
        return $pid;
    }

    static function encrypt($data, $rawOutput = false, $method = self::METHOD, $key = self::KEY, $iv = self::IV)
    {

        return openssl_encrypt ( $data, $method, $key, $rawOutput, $iv );
    }

    static function decrypt($data, $rawOutput = false, $method = self::METHOD, $key = self::KEY, $iv = self::IV)
    {

        return openssl_decrypt ( $data, $method, $key, $rawOutput, $iv );
    }
}
/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */