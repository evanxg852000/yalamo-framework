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
 * @filesource          Uri.php
 */

/*
 * URI HELPER
 *
  * Includes usefull functions for user that want to use the framework in procedural mode
 * about uri. These functions can be called from oo mode
 */

function GetUri(){
    $uri=new Uri() ;
    return $uri->Full();
}

function GetUriBase(){
    $uri=new Uri() ;
    return $uri->Base();
}

function GetUriSegement($num){
     $uri=new Uri() ;
     return $uri->Segment($num);
}

function GetUriController(){
    $uri=new Uri() ;
    return $uri->Controller();
}

function GetUriMethod(){
    $uri=new Uri() ;
     return $uri->Method();
}

function GetUriQueryString(){
    $uri=new Uri() ;
    return $uri->QueryString();
}

function Redirect($url){
    $uri=new Uri();
    $uri->Redirect($url);
}

function MvcUrl($controller,$method,$params){
   $uri=new Uri();
   return $uri->CreateMvc($controller, $method, $params);
}

function ClassicUrl($page,$params){
     $uri=new Uri();
     return $uri->CreateClassic($page, $params);
}

