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
 * @filesource          Path.php
 */

/*
 * PATH IMPLEMENTATION
 *
 * Contains the path manipulation/info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Path Class
 *
 * The implement the path functionalities and means of manipulating path
 */
final class Path {
    private $path;
    private $info;
    
    public function  __construct($path) {
        if(is_array($path)){ 
             $this->path=implode(DS, $path);
         }
         else {
            $this->path=$path;
         }
        $this->info=pathinfo($this->path);
        if((!$this->Extension()) && (substr($path, -1)!=DS)){
            $this->path .=DS;
        }
    }
    public function  __toString() {return "Object of Type: Path"; }
    
    public function  Append($piece){
       if(is_array($piece)){
           foreach ($piece as $val){
                $this->path .=DS.$val;
           }
       }
       else{
            $this->path .=DS.$piece;
        }
        $this->info=pathinfo($this->path);
    }

    public function Path(){
        return $this->path;
    }
    public function Segements(){
    $pathscheme="/";
    if(!strpos($this->path,$pathscheme)){
       $pathscheme="\\";
    }
        return explode($pathscheme, $this->path);
    }
    public function PathInfo(){
        return $this->info;
    }

    public function Directory(){
       return dirname($this->path);
    }
    public function FileName(){
        return basename($this->path);
    }
    public function Extension(){
        if(array_key_exists("extension", $this->info)){
            return $this->info["extension"];
        }
        else{
            return false;
        }
    }

    public function IsFile(){
        if($this->Extension()){
            return true;
        }
        else{
            return false;
        }
    }   
    public function IsDirectory(){
        return !$this->IsFile();
    }
   
}

