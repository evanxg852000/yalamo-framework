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
 * @filesource          Validator.php
 */

/*
 * VALIDATOR IMPLEMENTATION
 *
 * The class that implements user input validation using regular expression
 */

//------------------------------------------------------------------------------
/**
 * Validator Class
 *
 * Implements abstract methods from the DBDriver class for Sqlite engine
 */

final class Validator {
    const Username      ="/^[a-z0-9_-]{3,16}$/";
    const Password      ="/^[a-z0-9_-]{6,18}$/";
    const Email         ="/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
    const Ip            ="/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/";
    const Urlhttp       ="/^(http:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";
    const Urlhttps      ="/^(https:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";
    const Urlftp        ="/^(ftp:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";

    const Pcusa         ="//";
    const Pcuk          ="//";
    const Pcfrance      ="//";

    private $regex;

    public function __construct($rule) {
        $this->regex=$rule;
    }
    public function __toString() {return "Object of Type: Validator"; }
    public function Validate($subject){
        if(preg_match($this->regex, $subject)){
            return true;
        }
        return false;
    }


}
