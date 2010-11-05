<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Yalamo framework
 *
 * A fast,light, and constraint-free Php framework.
 *
 * @package		Yalamo
 * @author		Evance Soumaoro
 * @copyright           Copyright (c) 2009 - 2011, Evansofts.
 * @license		http://projects.evansofts.com/yalamof/license.html
 * @link		http://evansofts.com
 * @version		Version 0.1
 * @filesource          Encryption.php
 */

/*
 * ENCRYPTION IMPLEMENTATION
 *
 * Contains the directory manipulation/info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Encryption Class
 *
 * The class that contains encryption method that can be used to encrypt or decrypt data
 */
class Encryption extends Object {
    const  McryptDes        = MCRYPT_DES;
    const  McryptBlowfish   = MCRYPT_BLOWFISH;
    const  McryptGost       = MCRYPT_GOST;
    const  McryptRc2        = MCRYPT_RC2;
    const  OneWayMode       = 1;
    const  TwoWayMode       = 2;


    private $method;
    private $salt;
    private $mode;
    


    public function  __construct( $salt, $method=Encryption::McryptBlowfish , $mode=Encryption::OneWayMode) {
        $this->salt=substr($salt, 0, mcrypt_get_key_size($method,MCRYPT_MODE_ECB));
        $this->method=$method;
        $this->mode=$mode;
    }

    public function  __toString() {return "Object of Type: Encryption"; }

    public function Crypt($word){
        if($word==Yalamo::Void){return false;}
        if($this->mode===Encryption::OneWayMode){
            $encrypted= crypt($word, $this->salt);
        }
        else{
            $encrypted= mcrypt_encrypt($this->method, $this->salt, $word, MCRYPT_MODE_ECB);
        }
        return trim(base64_encode($encrypted));
    }

    public function Decrypt($word){
        if($this->mode===Encryption::OneWayMode){return false;}
        if($word==Yalamo::Void){return false;}
        return trim(mcrypt_decrypt($this->method, $this->salt,base64_decode($word),MCRYPT_MODE_ECB));
    }

    public static function UnicKey($prefix) {
        return str_replace(".",  Yalamo::Void,uniqid($prefix, true));
    }
    
}


