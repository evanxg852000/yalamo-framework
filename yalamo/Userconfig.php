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
 * USER CONFIGURATION
 *
 * Contains your system credentials and your preferences.
 * This is the only place to configure the framework
 * 
 */

//------------------------------------------------------------------------------
/**
 * Yalamo Configuration
 *
 * Configuration for the framework
 */

/*
 * Autoload Arrays
 *
 * These arrays define the classes that should be auto-loaded
 */
$AutoModules    = array('Cookie');
$AutoHelpers    = array('Validator','Uri','Html');
$AutoExtensions = array('Javascript');

//------------------------------------------------------------------------------
/**
 * Application Configuration
 *
 * Configuration for the application
 */

/**
 * Database Configuration
 *
 * Define your database credentials
 *
 * @param  string DBDRIVER      The the Database driver : [ MYSQL | POSTGRESQL | SQLITE ]
 * @param  string DBSERVER      The database server or location for Sqlite :
 * @param  string DBNAME        The database name
 * @param  string DBUSER        The database username
 * @param  string DBPASSWORD    The database password
 */
define("DBDRIVER", "MYSQL");
define("DBSERVER", "localhost");                   
define("DBNAME", "test");                         
define("DBUSER", "root"); 			
define("DBPASSWORD", ""); 


/**
 * Mvc Configuration
 *
 * Define the configuartion for the mode
 *
 * @param string SITEURL            The website root url : http://yalamof.com
 * @param string MODE               The usage mode wether mvc or classic: Mvc or Classic
 * @param string MVCPATH            The path of the mvc folder [ default YPATH."mvc/" ]
 *                                      inside the framework YPATH is a constant which
 *                                      definethe path of the framework
 * @param string DEFAULTCONTROLLER  The default controller
 * @param string DEFAULTPAGE  The default page when running in classic mode
 */
define("SITEURL", "http://localhost/Framework/");
define("MODE", "Mvc");
define("MVCPATH", YPATH."mvc/");                       
define("DEFAULTCONTROLLER", "Welcome");
define("DEFAULTPAGE", "Classic");

/**
 * Application Variables
 *
 * Define the application custome variable that are often use
 * @param Key=> Value paire as much as you like
 */
$AppConfig=array(
    'AdminEmail'=> 'evanxg852000@yahoo.fr',
    'Title'=>'Yalamo Framework',
    'Copyright'=> 'Evansofts 2010'
//  'key' => 'value'
);



/**
 * Alias Configuration
 *
 *
 * Alias Array
 *
 * Define aliases for the helper's function
 * @param bool ENABLEALIAS This constant activate aliases
 * @param Key=> Value paire as much as you like
 */
define("ENABLEALIAS",true);
$Alias=array(
    "fu"=>"getUri",
    "fc"=>"getController"
);

/**
 * Define whether the profilign is active or not
 */
define("ENABLEPROFILING",true);
