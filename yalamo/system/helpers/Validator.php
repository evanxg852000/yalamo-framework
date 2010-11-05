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
 * @filesource          Validator.php
 */

/*
 * REGULAR EXPRESSION HELPER
 *
 * Includes usefull functions for user that want to use the framework in procedural mode
 * about regular expressions. These functions can be called from oo mode
 */

function Matches($rule,$subject){
    preg_match_all($rule, $subject, $matchesarray);
    return $matchesarray;
}