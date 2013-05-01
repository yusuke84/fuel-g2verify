<?php
/**
 * Fuel Google Two-step verification Package
 *
 * @copyright  2013 Yusuke NAKA
 * @license    MIT License
 *
 */

namespace G2verify;

class G2verify_Driver {

    protected $config = null;
    protected $initial_key = null;
    protected $product_name = null;
    protected $timestep = 30;
    protected $interval = 3;
    protected $otplength = 6;

    public function __construct(){
        $_config = \Config::load('g2verify', true);
        $this->initial_key = $_config['initial_key'];
        $this->product_name = $_config['product_name'];

    }

    public function generateSecret(){
        $_base32str = "ABCDEFGHIJKLNMOPQRSTUVWXYZ234567";
        $_secret = "";
        for($_cnt = 0;$_cnt < 16;$_cnt++){
            $_secret .= $_base32str[mt_rand(0,31)];
        }
        return $_secret;

    }

    public function generateOTP($secret,$timestamp = null){
        $secret = $this->getSecret($secret);
        $timestamp = $timestamp == null ? $this->getTimestamp():$timestamp;
        $_binarykey = \G2verify_Base32::decode($secret);
        $_binarytimestamp = pack('N*',0).pack('N*',$timestamp);
        $_hash = hash_hmac("sha1",$_binarytimestamp,$_binarykey,true);
        $_code = Array();
        for($_cnt = 0;$_cnt < 20;$_cnt++){
            array_push($_code,ord(substr($_hash, $_cnt, 1)));
        }
        $_offset = $_code[19] & 0xf;
        $_result = ($_code[$_offset]  & 0x7f) << 24 | ($_code[$_offset+1] & 0xff) << 16 | ($_code[$_offset+2] & 0xff) <<  8 | ($_code[$_offset+3] & 0xff);
        $_format = "%0".$this->otplength."d";
        $_otp = sprintf($_format,$_result % pow(10,$this->otplength));

        return $_otp;

    }

    public function generateQRcode($username,$secret){
        $secret = $this->getSecret($secret);
        $_param = urlencode("otpauth://totp/".$this->product_name." : ".$username."?secret=".$secret);
        return "https://www.google.com/chart?chs=200x200&chld=M|0&cht=qr&chl=".$_param;

    }

    public function verify($key,$secret){
        $secret = $this->getSecret($secret);
        $_basetime = $this->getTimestamp();
        for($_cnt = ($_basetime - $this->interval);$_cnt <= ($_basetime + $this->interval);$_cnt++){
            $_otp = $this->generateOTP($secret,$_cnt);
            if($key == $_otp){
                return true;
            }
        }
        return false;

    }

    protected function getTimestamp(){
        return floor( \Date::time()->get_timestamp() / $this->timestep);

    }

    protected function getSecret($secret){
        return $this->initial_key != null ? $this->initial_key:$secret;

    }

}
