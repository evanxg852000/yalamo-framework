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
 * @filesource          Core.php
 */

/*
 * URI IMPLEMENTATION
 *
 * Definition of the uri functionalities
 */

//------------------------------------------------------------------------------
/**
 * Yalamo Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
Class Uri {
    /**
     * Base uri, define in Userconfig.php file is the web app url
     * @var string
     * @example http://evansofts.com/
     */
    private $baseuri;

    /**
     * Full uri in the client browser
     * @var string
     * @example http://evansofts.com/services/consultancy/option/vip
     */
    private $requesturi;         
    
    /**
     * The uri segments
     * @var array
     * @example  [services, consultancy, option,vip ]
     */
    private $segments=array();

    /**
    * The current requested page in classic mode
    * @var string
    * @example  services
    */
    private $page;

    /**
     * The current requested controller
     * @var string
     * @example  services
     */
    private $controller;

    /**
     * The current requested method of the controller
     * @var string
     * @example  consultancy
     */
    private $method;

    /**
     * The array containing the query string
     * @var array
     * @example [ option,vip ]
     */
    private $querystr=array();   

    /**
     * Constructor
     */
    public function __construct(){
        $this->baseuri=SITEURL ;
        $this->requesturi=$this->RequestUri();
        $segementstring=str_replace($this->baseuri, "",  $this->requesturi );
        $this->segments=explode('/',$segementstring);

        if(MODE==Yalamo::Classic){
          //page
          $this->page=DEFAULTPAGE;
          if(array_key_exists(0, $this->segments) ){
               if( $this->segments[0]!=""){
                  $this->page=$this->segments[0];
               }
            }
           //query string
           for($i=1; $i< count($this->segments);$i++ ){
                if(array_key_exists($i, $this->segments)){
                     $this->querystr[]=$this->segments[$i];
                     $_GET[$i]=$this->segments[$i];
                }
            }
            $this->controller=null;
            $this->method=null;
        }
        else{
            //controller
            $this->controller=DEFAULTCONTROLLER;
            if(array_key_exists(0, $this->segments) ){
               if( $this->segments[0]!=""){
                  $this->controller=$this->segments[0];
               }
            }
            //method
            if(array_key_exists(1, $this->segments)){
                $this->method=$this->segments[1];
            }
            else {
                $this->method="Index";
            }
            //query string
            for($i=2; $i< count($this->segments);$i++ ){
                if(array_key_exists($i, $this->segments)){
                     $this->querystr[]=$this->segments[$i];
                     $_GET[$i]=$this->segments[$i];
                }
            }
            $this->page=null;
        }

    }
    
    public function  __toString() {return "Object of Type: Uri"; }

    /**
     *@access private
     * @return string
     */
    private function RequestUri() {
        $url = 'http';
        $port='';
        if (isset($_SERVER["HTTPS"]) and ( $_SERVER["HTTPS"]== "on"))  {	$url .= "s"; }
         $url .= "://";
         if ($_SERVER["SERVER_PORT"] !== "80") {
            $port =':'.$_SERVER["SERVER_PORT"];
         }
         $url .= $_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
         return $url;
    }
    
    /**
     * The accessor to the base uri
     * 
     * @return string The base uri
     */
    public function Base() {
        return $this->baseuri;
    }

    /**
     * The accessor to the full uri
     * 
     * @return string The full uri
     */
    public function Full() {
        return $this->requesturi;
    }
    
    /**
     * The accessor  to a portion of the uri
     *
     * @param int $num  The index of the uri registry
     * @return string   The portion value
     */
    public function Segment($num){
        if(array_key_exists($num , $this->segments)){
            return $this->segments[$num];
        }
        else {
            return false;
        }
    }

    /**
     * The accessor to the  page of the uri
     *
     * @return String The page of the uri
     */
    public function Page() {
        return ucwords($this->page);
    }

    /**
     * The accessor to the  controller of the uri
     * 
     * @return String The controller of the uri 
     */
    public function Controller() {
        return ucwords($this->controller);
    }

    /**
     * The accessor to the  method of the uri
     *
     * @return String The method of the uri
     */
    public function Method() {
        return ucwords($this->method);
    }
    
    /**
     * The accessor to the  querystring of the uri
     * 
     * @return String The querystring of the uri 
     */
    public function QueryString() {
        return $this->querystr;
    }

    /**
     * The methode to redirect the user
     *
     * @param string $url The new location
     */
    public function Redirect($url){
        header("Location: $url" );
        exit ();
    }

    /**
     * This method create a url(to be used as href ) in mvc mode
     *
     * @param string $controller The controller of the url
     * @param string $method     The method of the url
     * @param strign $params     The query string
     */
    function CreateMvc($controller,$method,$params){
        $paramstr=Yalamo::Void;
        if(is_array($params)){
            foreach($params as $param){
                $paramstr .="/".$param;
            }
        }
        if(substr($this->Base(), -1)==="/"){
         return $this->Base()."$controller/$method/$paramstr";
        }
        return $this->Base()."/$controller/$method/$paramstr";
    }

    /**
     * This method create a url(to be used as href ) in classic mode
     *
     * @param string $page       The page name
     * @param strign $params     The query string
     */
    function CreateClassic($page,$params){
        $paramstr=Yalamo::Void;
        if(is_array($params)){
            foreach($params as $param){
                $paramstr .="/".$param;
            }
        }
        if(substr($this->Base(), -1)==="/"){
         return $this->Base()."$page/$paramstr";
        }
        return $this->Base()."/$page/$paramstr";
    }
    
}