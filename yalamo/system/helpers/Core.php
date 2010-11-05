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
 * CORE HELPER
 *
 * Includes usefull functions for user that want to use the framework in procedural mode
 * about core functionalities. These functions can be called from oo mode
 */

function AppConfig($key){
    return Environment::Application($key);
}

function loadModule($modules){
    $load=new Loader();
    if(is_array($modules)){
        $load->Module($modules);
        return;
    }
    $load->Modules($modules);
}

function loadHelper($helpers){
    $load=new Loader();
    if(is_array($helpers)){
        $load->Helper($helpers);
        return;
    }
    $load->Helpers($helpers);
}

function loadExtension($extensions){
    $load=new Loader();
    if(is_array($extensions)){
        $load->Extension($extensions);
        return;
    }
    $load->Extensions($extensions);
}

function loadModel($model){
    $load=new Loader();
    return $load->Model($model);
}

function loadView($view, $data=null){
     $load=new Loader();
     $load->View($view, $data);
}

function loadController($controller){
    $load=new Loader();
    $load->Controller($controller);
}

