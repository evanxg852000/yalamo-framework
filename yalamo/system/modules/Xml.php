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
 * @filesource          Xml.php
 */

/*
 * XML IMPLEMENTATION
 *
 * Contains xml manipulation functionalities
 */

//------------------------------------------------------------------------------
/**
 * Xml Class
 *
 * Define a pseudo wrapper arround simplexml element to provide shorthand functionalities
 */
class Xml extends Object {
    private $file;
    private $string;
    private $simplexmlobject;

    public function __construct($argument) {
        if(is_file($argument)){
            $this->file=$argument;
            $this->string=  file_get_contents($argument) ;
            $this->simplexmlobject=@simplexml_load_file($argument);
            if( $this->simplexmlobject===false){
                $this->Collect(Error::YE101);
            }
            return ;
         }
         $this->file=Yalamo::Void;
         $this->string=$argument;
         $this->simplexmlobject=  @simplexml_load_string($argument);
         if( $this->simplexmlobject===false){
            $this->Collect(Error::YE101);
         }        
    }
    public function __toString() {return "Object of Type: Xml";}
    public function __set($name, $value) {
        $this->simplexmlobject->$name=$value;
    }
    public function __get($name){
       return $this->simplexmlobject->$name;
    }

    public function XmlObject(){
        return $this->simplexmlobject;
    }
    public function String(){
        return $this->string;
    }
    public function Data(){
        return (array)  $this->simplexmlobject;
    }

    public function AddChild($name, $value=Yalamo::Void){
        return $this->simplexmlobject->addChild($name, $value);
    }
    public function AddAttribute($name, $value=Yalamo::Void){
        return $this->simplexmlobject->addAttribute($name, $value);
    }

}