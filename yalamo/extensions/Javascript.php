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
 * @filesource          Javascript.php
 */

/*
 * JAVASCRIPT EXTENSION
 *
 *  This extension loads popular javascript libraries from google
 */

//------------------------------------------------------------------------------
/**
 * Jslib Class
 *
 * Enumerates availabe libraries
 */
final class Jslib{
 const Chromeframe      =1;
 const Dojo             =2;
 const Extcore          =3;
 const Jquery           =4;
 const Jqueryui         =5;
 const Mootools         =6;
 const Prototype        =7;
 const Scriptaculous    =8;
 const Swfobject        =9;
 const Webfont          =10;
 const Yui              =11;
}

//------------------------------------------------------------------------------
/**
 * Javascript Class
 *
 * Javascript library loading implementation
 */
final class Javascript {
   private $returnstr;
   public function  __construct() {
        $this->returnstr="<script type=\"text/javascript\" src=\"#library#\"></script>";
   }

   public function  __toString() {return "Object of Type: Javascript"; }
   public function Get($library,$version){
        switch ($library) {
            case Jslib::Chromeframe:
                $lib="http://ajax.googleapis.com/ajax/libs/chrome-frame/#version#/CFInstall.min.js";
                break;
            case Jslib::Dojo:
                $lib="http://ajax.googleapis.com/ajax/libs/dojo/#version#/dojo/dojo.xd.js";
                break;
            case Jslib::Extcore:
                $lib="http://ajax.googleapis.com/ajax/libs/ext-core/#version#/ext-core.js";
                break;
            case Jslib::Jquery:
                $lib="http://ajax.googleapis.com/ajax/libs/jquery/#version#/jquery.min.js";
                break;
            case Jslib::Jqueryui:
                $lib="http://ajax.googleapis.com/ajax/libs/jqueryui/#version#/jquery-ui.min.js";
                break;
            case Jslib::Mootools:
                $lib="http://ajax.googleapis.com/ajax/libs/mootools/#version#/mootools-yui-compressed.js";
                break;
            case Jslib::Prototype:
                $lib="http://ajax.googleapis.com/ajax/libs/prototype/#version#/prototype.js" ;
                break;
            case Jslib::Scriptaculous:
                $lib="http://ajax.googleapis.com/ajax/libs/scriptaculous/#version#/scriptaculous.js" ;
                break;
            case Jslib::Swfobject:
                $lib="http://ajax.googleapis.com/ajax/libs/swfobject/#version#/swfobject.js" ;
                break;
            case Jslib::Webfont:
                $lib="http://ajax.googleapis.com/ajax/libs/webfont/#version#/webfont.js";
                break;
            case Jslib::Yui:
                $lib="http://ajax.googleapis.com/ajax/libs/yui/#version#/build/yuiloader/yuiloader-min.js";
                break;
            default:
                        $lib="";
                break;
        }
        if($lib != ""){
            $lib=str_replace("#version#", $version, $lib);
            $this->returnstr=str_replace("#library#", $lib, $this->returnstr);
            return $this->returnstr;
        }else{
            return false;
        }

   }
   public static function Load($library,$version,$insert=true){
        $jsObj=new Javascript();
        $tag=$jsObj->Get($library, $version);
        if($insert){
              echo $tag;
        }
        return $tag;
   }
}


//------------------------------------------------------------------------------
/**
 * Helper Functions
 */

/* Helper function implementation */
function loadjs($library,$version,$insert=true){
    Javascript::Load($library, $version,$insert);
}