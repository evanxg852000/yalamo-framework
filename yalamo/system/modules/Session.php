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
 * @filesource          Session.php
 */

/*
 * SESSION IMPLEMENTATION
 *
 * Contains session handling functionalities
 */

//------------------------------------------------------------------------------
/**
 * Session Class
 *
 * Define methods to create and manipulate sessions
 */
class Session extends Object {
    private static  $resgistry;
    private $id;

    public function  __construct() {
        session_start();
        $this->id=$_COOKIE["PHPSESSID"];
        self::$resgistry=$_SESSION;
    }
    public function  __toString() {return "Object of Type: Session"; }
    
    public function Id(){
        return $this->id;
    }
    public function Registry(){
        return self::$resgistry;
    }
    public function Set($key, $value){
         $_SESSION[$key]=$value;
        self::$resgistry=$_SESSION;
    }    
    public function Get($key){
        return $this->$key;
        if((array_key_exists($key, self::$resgistry)) && (array_key_exists($key, $_SESSION))){
            return self::$resgistry[$key];
        }
        $this->Collect(Error::YE100);
        return false;
    }
    public function Clear($keys=Yalamo::All){
        if($keys===Yalamo::All){
            foreach ($_SESSION as $key=>$val){
                unset ($_SESSION[$key]);
            }
            self::$resgistry=$_SESSION;
            return true;
        }
        if(is_array($keys)){
            foreach($keys as $key){
                unset ($_SESSION[$key]);
            }
            self::$resgistry=$_SESSION;
            return true;
        }
        else {
           unset ($_SESSION[$keys]);
           self::$resgistry=$_SESSION;
           return true;
        }


    }
    public function End($redirect=Yalamo::Void){
        session_unset();
        session_destroy();
        self::$resgistry=$_SESSION;
        if($redirect !==Yalamo::Void){
            $uri=new Uri();
            $uri->Redirect($redirect);
        }
    }
     
}