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
 * @filesource          Cookie.php
 */

/*
 * COOKIE IMPLEMENTATION
 *
 * Contains the cookie manipulation functionalities
 */

//------------------------------------------------------------------------------
/**
 * Cookie Class
 *
 * The class that contains the cookie manipulation methods
 */
class Cookie{
    private static  $resgistry;
    private $lifetime;
    private $path;

    public function  __construct($liftime=31536000,$path=Yalamo::Void) {
       self::$resgistry=$_COOKIE;
       if(is_numeric($liftime)){
           $this->lifetime=$liftime;
       }
       if(is_string($liftime)){
           $unite=substr($liftime, -1, 1);
           $val=(int)substr($liftime,0, -1);
           switch ($unite) {
               case "Y":
                        $this->lifetime=$val*365*24*3600;
                    break;
               case "D":
                        $this->lifetime=$val*24*3600;
                    break;
                case "H":
                        $this->lifetime=$val*3600;
                    break;
                case "M":
                        $this->lifetime=$val*60;
                    break;
            }
       }
       $this->path=$path;
    }   
    public function  __toString() {
        return "Object of Type: Cookie";
    }

    public function Registry(){
        return self::$resgistry;
    }
    public function Set($key, $value){
        if($this->path===Yalamo::Void){
           setcookie($key, $value,  time()+$this->lifetime);
           self::$resgistry=$_COOKIE;
           return  true;
       }
       else{
           setcookie($key, $value,  time()+$this->lifetime, $this->path);
           self::$resgistry=$_COOKIE;
           return  true;
       }
    }
    public function Get($key){
        if((array_key_exists($key, self::$resgistry))&&(array_key_exists($key, $_COOKIE))){
            return self::$resgistry[$key];
        }
        $this->Collect(Error::YE100);
        return false;
    }
    public function Clear($keys=Yalamo::All){
        if($keys===Yalamo::All){
            foreach ($_COOKIE as $key=>$val){
                $this->Set($key, Yalamo::Void);             
            }
            self::$resgistry=$_COOKIE;
            return true;
        }
        if(is_array($keys)){
            foreach($keys as $key){
                $this->Set($key,  Yalamo::Void);
            }
            self::$resgistry=$_COOKIE;
            return true;
        }
        else {
           $this->Set($keys,  Yalamo::Void);
           self::$resgistry=$_COOKIE;
           return  true;
        }
    }

    
}
