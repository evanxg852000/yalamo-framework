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
 * @filesource          Dataset.php
 */

/*
 * Dataset IMPLEMENTATION
 *
 * Contains the .net like dataset implemetation for the framework
 */

//------------------------------------------------------------------------------
/**
 * Dataset Class
 *
 * The class that contains the dataset functionalities, methods and many clever features
 */
class Dataset extends Object{
    private $registry;
    //,$schema is an array or collumn headers
    //TODO finishe Dataset before 20/11/2010
    private function __construct($schema) {
        $this->registry=array();
    }
    public function __toString() {return "Object of Type: Dataset";}
    public function __set($name, $value) {
        if(is_array($value)){
          $this->registry[$name]=$value;  
        } 
    }
    public function __get($name) {
        if(array_key_exists($name, $this->registry)){
            return $this->resgistry[$name];
        }
            return false;
    }

    public function FromDatabase($tables){

    }
    public function FromXml($argument,$schema){

    }
    public function FromJson($argument,$schema){

    }
    public function FromCvs($argument,$schema){

    }

    public function WriteDatabase() {

    }
    public function WriteXml($file){

    }
    public function WriteJson($file){

    }
    public function WriteCvs($file){

    }
  
}
