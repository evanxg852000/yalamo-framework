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
 * @version		Version 1.0
 * @filesource          Userconfig.php
 */


/*
 * ENVIRONMENT IMPLEMENTATION
 *
 * This file contains definition of environement variable and provide
 * the application variable
 */

//------------------------------------------------------------------------------
/**
 * Evironment Class
 *
 * The class comprise of pure static methods to get variable from different PHP
 * Global Array.
 */
class Environment extends Object{

     /**
     * Gets a value from the $_ENV global array based on the key specified
      *
     * @param string $key The key in the $_ENV global array
     * @return mixed      It returns false if there is no match
     */
    public static function Env($key){
       if(!array_key_exists($key,$_ENV)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_ENV[$key];
    }

     /**
     * Gets a value from the $_REQUEST global array based on the key specified
      *
     * @param  string $key  The key in the $_REQUEST global array
     * @return mixed        It returns false if there is no match
     */
    public static function Request($key){
       if(!array_key_exists($key,$_REQUEST)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_REQUEST[$key];
    }

     /**
     * Gets a value from the $_SERVER global array based on the key specified
     * @param   string $key     The key in the $_SERVER global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Server($key){
        if(!array_key_exists($key,$_SERVER)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_SERVER[$key];
    }

    /**
     * Gets a value from the $_SESSION global array based on the Key specified
     * @param   string $key     The key in the $_SESSION global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Session($key){
       if(!array_key_exists($key,$_SESSION)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_SESSION[$key];
    }

     /**
     * Gets a value from the $_COOKIE global array based on the Key specified
     * @param   string $key     The key in the $_COOKIE global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Cookie($key){
        if(!array_key_exists($key,$_COOKIE)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_COOKIE[$key];
    }

    /**
     * Gets a value from the $_GET global array based on the Key specified
     * @param   string $key     The key in the $_GET global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Get($key){
        if(!array_key_exists($key,$_GET)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_GET[$key];
    }

    /**
     * Gets a value from the $_POST global array based on the Key specified
     * @param   string $key     The key in the $_POST global array
     * @return  mixed           It returns false if there is no match
     */
    public static function Post($key){
        if(!array_key_exists($key,$_POST)) {
            $this->Collect(Error::YE100);
            return false;
        }
         return $_POST[$key];
    }

    /**
     * Gets a value from the $_FILES global array based on the Key specified
     * @param   string $key     The key in the $_FILES global array
     * @return  mixed           It returns false if there is no match
     */
    public static function File($key){
        if(!array_key_exists($key,$_FILES)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $_FILES[$key];
    }

    /**
     * Gets a value from the $AppConfig global array based on the key specified
     * @global array $AppConfig
     * @param  string $key The key in the $AppConfig global array
     * @return string      It returns false if there is no match
     */
    public static function Application($key){
        global $AppConfig;
        if(!array_key_exists($key,$AppConfig)) {
           $this->Collect(Error::YE100);
           return false;
        }
         return $AppConfig[$key];
    }

}