<?php
/**
 * Fuel Google Two-step verification Package
 *
 * @copyright  2013 Yusuke NAKA
 * @license    MIT License
 *
 */

namespace G2verify;

class G2verify {

    public static $version = '1.0.0';

    protected static $driver = null;

    public static function _init(){

        static::$driver = new \G2verify_Driver();

    }

    public static function getSecret(){

        return static::$driver->generateSecret();

    }

    public static function getQRcodeurl($username,$secret = null){

        return static::$driver->generateQRcode($username,$secret);

    }

    public static function verify($key,$secret = null){

        return static::$driver->verify($key,$secret);

    }

    public static function getOTP($secret = null){

        return static::$driver->generateOTP($secret);

    }

}