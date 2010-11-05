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
 * @filesource          Form.php
 */

/*
 * FORM IMPLEMENTATION
 *
 * The class that implements user input validation using regular expression
 */

//------------------------------------------------------------------------------
/**
 * Validator Class
 *
 * Implements abstract methods from the DBDriver class for Sqlite engine
 */

final class Form extends Object {
    const  Get    = "GET";
    const  Post   = "POST";

    private $code;
    private $controls;

    public function  __construct($name, $action, $mixedata=false ,$method=Form::Post) {
        if($mixedata){
            $option="enctype=\"multipart/form-data\"";
        }
        else {
            $option=Yalamo::Void;
        }
        $this->code="<form name=\"$name\" action=\"$action\" method=\"$mathod\"  $option  >";
        $this->controls=array();
    }
    public function  __toString() {return "Object of Type: Form"; }

    public function Add($control){
        if(is_callable(array($control,"Code"))){
            $this->controls[$control->Name()]=$control;
            return $control;
        }

    }
    public function Remove($name){
        if(array_key_exists($name, $this->controls)){
            //$this->controls
            unset($this->controls[$name]);
        }

    }
    public function Close($dump=true){
        foreach ($this->controls as $control){
            $this->code .=$control->Code();
        }
        $this->code .="</form>";
        if($dump){
            echo $this->code;
        }
        return $this->code;
    }

}



abstract class Control extends Object {
    protected $name;
    protected $stroption;
 
    public function __construct($option) {
        $this->name=  Yalamo::Void;
        $this->stroption=$this->formatoptions($option);
    }
    public function __toString(){return "Object of Type: Control"; }
    private function formatoptions($options){
        $stroption=Yalamo::Void;
        if(!is_array($options)){
           return;
        }
        foreach ($options as $name=>$value){
            if(is_numeric($name)){continue;}
            $stroption .=" $name=\"$value\" ";
        }
        return $stroption;
    }

    public function Name(){
        return $this->name;
    } 
    public abstract function Code();
   
}

/*=====================================================*/

final class Input extends Control {
    const Button    ="type=\"button\"";
    const Checkbox  ="type=\"checkbox\"";
    const File      ="type=\"file\"";
    const Hidden    ="type=\"hidden\"";
    const Image     ="type=\"image\"";
    const Password  ="type=\"password\"";
    const Radio     ="type=\"radio\"";
    const Reset     ="type=\"reset\"";
    const Submit    ="type=\"submit\"";
    const Text      ="type=\"text\"";

    private $type;

    private $accept;
    private $alt;
    private $checked;    //bool
    private $disabled; //bool
    private $maxlength;
    private $readonly;
    private $size;
    private $src;
    private $value;


    public function  __construct($type,$name,$option) {
        parent::__construct($option);
        $this->name=$name;
        $this->type=$type;

        $this->accept=null;
        $this->alt=null;
        $this->checked=null;
        $this->disabled=null;
        $this->maxlength=null;
        $this->readonly=null; //bool
        $this->size=null;
        $this->src=null;
        $this->value=null;
    }
    public function Accept($value){
        $this->accept=$value;
    }
    public function Alt($value){
        $this->alt=$value;
    }
    public function Checked(){
        $this->checked=true;
    }
    public function Disabled(){
        $this->disabled=true;
    }
    public function Maxlength($value){
        if(is_numeric($value)){
            $this->maxlength=$value;
            return;
        }
        $this->Collect(Error::YE101);
    }
    public function Readonly(){
        $this->readonly=true;
    }
    public function Size($value){
        if(is_numeric($value)){
            $this->size=$value;
            return;
        }
        $this->Collect(Error::YE101);
    }
    public function Src($value){
        $this->src=$value;
    }
    public function Value($value){
        $this->value=$value;
    }
    public function  Code() {
        $code .="<input $this->type name=\"$this->name\" id=\"$this->name\"";

        if((!is_null($this->accept)) && ($this->type==Input::File)){$code .="accept=\"$this->accept\"";}
        if((!is_null($this->alt)) && ($this->type==Input::Image)){$code .="alt=\"$this->alt\"";}
        if((!is_null($this->check)) && (($this->type==Input::Checkbox)||($this->type==Input::Radio))){
            $code .="checked=\"checked\"";
        }
        if(!is_null($this->disabled)){$code .="disabled=\"disabled\"";}
        if((!is_null($this->maxlength))){$code .="maxlength=\"$this->maxlength\"";}
        if((!is_null($this->readonly))){$code .="readonly=\"readonly\"";}
        if((!is_null($this->size))){$code .="size=\"$this->size\"";}
        if((!is_null($this->src)) && ($this->type==Input::Image)){$code .="src=\"$this->src\"";}
        if((!is_null($this->value))){$code .="value=\"$this->value\"";}
        $code .=$this->stroption;
        $code .=" />";
        return $code;
    }

}

final class Textarea extends Control {
    private $cols;
    private $rows;
    private $disabled;
    private $readonly;


    public function  __construct($name, $option) {
        parent::__construct($name,$option);

        $this->cols=null;
        $this->rows=null;
        $this->disabled=null;
        $this->readonly=null;
    }  
    public function __toString(){return "Object of Type: TextBox"; }

    public function Cols($value){
        if(is_numeric($value)){
            $this->cols=$value;
            return;
        }
        $this->Collect(Error::YE101);
    }
    public function Rows($value){
        if(is_numeric($value)){
            $this->rows=$value;
            return;
        }
        $this->Collect(Error::YE101);
    }
    public function Disabled(){
        $this->disabled=true;
    }
    public function Readonly(){
        $this->readonly=true;
    }

    public function  Code() {     
       return $code;
    }
}

final class Label extends control{
    private $text;
    private $for;
    
    public function  __construct($text,$for, $option) {
        parent::__construct($option);
        $this->text=$text;
        $this->for=$for;
    }
    
    public function  Code() {
        $code="<label for=\"$this->for\">$this->text</label>" ;
        return $code;
    }
    
}




