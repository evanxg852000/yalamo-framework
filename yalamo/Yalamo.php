<?php 
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
 * @filesource          Yalamo.php
 */

/*
 * YALAMO KERNEL
 *
 * Includes all the framework base component and define some constants use
 * throughout the framework
 *
 */

/**
 * Set error level
 */
error_reporting(E_ALL);

/**
 * Define file system variable as constants
 */
define("DS",DIRECTORY_SEPARATOR);
define('EXT', '.php');
define("YPATH",pathinfo(__FILE__, PATHINFO_DIRNAME).DS);

/**
 * Include required files
 */
require_once("Userconfig".EXT);
require_once("system".DS."core".DS."Coreconfig".EXT);

require_once(YCOREFILE);
require_once(YERRORFILE);
require_once(YMODELFILE);
require_once(YURIFILE);
require_once(YMVCFILE);


/**
 *  Autoload user prefered files using the autoload array
 */
Yalamo::Autoload($YAutoLoad);

/**
 * Initialise Profiler
 */
if(ENABLEPROFILING){
   Profiler::CheckPoint("Init");
}
