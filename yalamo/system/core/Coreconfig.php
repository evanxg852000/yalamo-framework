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
 * @filesource          Userconfig.php
 */

/*
 * CORE CONFIGURATION
 *
 * Contains base configuration of the framework
 * and assemble some user defined configuration
 */

define('YPACKAGE','Yalamo');
define('YTYPE','PHP Framework');
define('YVERSION','0.1');
define('YLICENCE','MIT');
define('YAUTHOR','Evance Soumaoro');

define('YCOREFILE'  ,  YPATH.'system'.DS.'core'.DS.'Core'.EXT );
define('YERRORFILE'  , YPATH.'system'.DS.'core'.DS.'Inspector'.EXT );
define('YMODELFILE' ,  YPATH.'system'.DS.'core'.DS.'Model'.EXT);
define('YURIFILE'   ,  YPATH.'system'.DS.'core'.DS.'Uri'.EXT);
define("YMVCFILE"   ,  YPATH.'system'.DS.'core'.DS.'Mvc'.EXT);


define('YMODULEDIR'    , YPATH.'system'.DS.'modules'.DS);
define('YHELPERSDIR'   , YPATH.'system'.DS.'helpers'.DS);
define('YEXTENTIONDIR' , YPATH.'extensions'.DS);

/**
 * Assemble autoload array
 */
$YAutoLoad = array (
    'modules'       =>$AutoModules,
    'helpers'       =>$AutoHelpers,
    'extensions'    =>$AutoExtensions
);


