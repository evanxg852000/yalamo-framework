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
 * IMAGE IMPLEMENTATION
 *
 * Implements some Image manipulation functionalities using imagelib
 */

//------------------------------------------------------------------------------
/**
 * Image Class
 *
 * The class that contains the framework enumeration and static methods
 * for managed errors that can be reported.
 */
class Image extends Object{
    public function  __construct() {
        $this->Collect(Error::YE001);
    }
    public function  __toString() {return "Object of Type: Image"; }


}