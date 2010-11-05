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
 * @filesource          Inspector.php
 */

/*
 * DEBUGGER IMPLEMENTATION
 *
 * Define diferrent kind of errors and an Error reporting class
 * for reporting errors easily when developping
 */

//------------------------------------------------------------------------------
/**
 * Error Class
 *
 * The class that contains the framework enumeration and static methods
 * for managed errors that can be reported.
 */
final class Error {
    /* Base zone */
    const YE000 = "YE000| There is not an error";
    const YE001 = "YE001| Method or function not implemented";
    
    /* Arguments zone */
    const YE100 = "YE101| Invalid index suplied for array";
    const YE101 = "YE101| Invalid argument suplied ";

    /* File zone */
    const YE200 = "YE200| File not found in the specified path";
    const YE201 = "YE201| Directory not found in the specified path";
    const YE202 = "YE202| Access denied on specified file";
    const YE203 = "YE203| Impossible to upload file";
    const YE204 = "YE204| Directory operation not successfully completed";
    const YE205 = "YE205| File operation not successfully completed";

    /* Database zone */
    const YE300 = "YE300| Unable to connect to the database";
    const YE301 = "YE301| SQl query execution error";
    
    /* Misc zone */
    const YE400 = "YE400| Unable to connect to mail server";
    const YE401 = "YE401| Unable to send the mail";


    private $num;
    private $string;
    private $subject; 

    /**
     * Error constructor 
     *
     * @param Error::Enum     $type      The Error type, constant of Error class
     * @param Object          $subject   The subject is the Object on which the error was raised
     */
    public function  __construct($type=Error::None,$subject=null) {
        $parts=explode("|",$type);    
        $this->num=str_replace("|","",$parts[0]);
        $this->string=$parts[1];
        $this->subject=$subject;
    }

    /**
     * Return the Error string 
     *
     * @param   bool    $dump  The optional parameter to explode the subject if set to true
     * @return  string         The description of the error
     */
    public function  __toString() {
        return "Error: ".$this->Num()." , ".$this->String()." With Var= ".$this->Subject(true);
    }
    
    /**
     * Accessor to the error num
     *
     * @return string  The error identifier
     */
    public function Num(){
        return $this->num;
    }

    /**
     *Accessor to the error description
     *
     * @return string The error description
     */
    public function String(){
        return $this->string;
    }

    /**
     * Accessor to the error subject explode the object if dump is true
     *
     * @param  bool $dump   The optional parameter to explode the subject if set to true
     * @return mixed        The object on which the error hapened
     */
    public function Subject($dump=false){
        if($dump){
            var_dump($this->subject);
        }
        return $this->subject;
    }    
    
}


//------------------------------------------------------------------------------
/**
 * Inspector Class
 *
 * The class that serves as the debugger in the framework.
 * it has only one instance
 */
final class Inspector {
    private static $instance=null;
    private $errors;

    private function  __construct() {
        $this->errors=array(); 
    }
    private function  __clone() {}

    /**
     * Getter of the Inspector instance
     * 
     * @static
     * @return Inspector  The inspector instance
     */
    public static function  Instance(){
        if(!self::$instance){
            self::$instance=new Inspector();
        }
        return self::$instance;
    }

    /**
     * Static conveniant method to add error to the inspector instance
     *
     * @static
     * @param Error::Enum   $type       The error type constant of Error Class
     * @param mixed         $subject    The Object on which the error was raised
     */
    public static function AddError($type,$subject=null){
         $inspector=Inspector::Instance();
         $inspector->Add($type,$subject);
    }

     /**
     * Method to add error to the inspector instance
     *
     * @param Error::Enum   $type       The error type constant of Error Class
     * @param mixed         $subject    The Object on which the error was raised
     */
    public function Add($type,$subject=null){
        $error=new Error($type,$subject);
        $this->errors[]=$error;
    }
    
    /**
     * Getter of specific Error in the inspector registry
     * 
     * @param int $offset   The index of the entry
     * @return Error        An error object from the inspector registry
     */
    public function Error($offset=Yalamo::All){
        if($offset==Yalamo::All){
            return $this->errors;  
        }
        else{
            return $this->errors[$offset];
        }

    }
    
    /**
     * Walk through the inspector registry to report about every error
     *
     * @param bool $dump   The optional parameter to explode the subject if set to true
     * @return string      The report text
     */
    public function Investigate($dump=false){
        $log="";
        foreach ($this->errors as $error) {
            $str =$error->__toString().Yalamo::Endline;
            if($dump){
                echo $str;
                $error->Subject(true);
            }
            $log.=$str;
        }
        return $log;
    }

    public function Log($file=Yalamo::Void){
        if($file==Yalamo::Void){
            $logfile=YPATH."log.log";
        }
        else {
            $logfile=$file;
        }
        $f=new File($logfile);
        $f->Append($this->Investigate());
    }
          
}