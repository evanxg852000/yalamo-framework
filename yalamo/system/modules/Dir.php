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
 * @filesource          Dir.php
 */

/*
 * DIR IMPLEMENTATION
 *
 * Contains the directory manipulation and info functionalities
 */

//------------------------------------------------------------------------------
/**
 * Dir Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */

final class Dir extends Object{

    private $path;
 
    public function  __construct($path) {
        $this->path=new Path($path);
        if($this->path->IsFile()){
            $this->path=new Path($this->path->Directory());
        }
    }
    public function  __toString() {return "Object of Type: Directory"; }
    public function  PathObject(){
        return $this->path;
    }


    public function  Create($recurssive=true){
        if (@mkdir($this->path->Path(), 0750,$recurssive)) {
            return true;
        }
         $this->Collect(Error::YE204);
         return false;
    }

    public function  Delete(){
        return $this->erase($this->path->Path());
    }

    public function  Entries($filter=Yalamo::All,$sort=true){
        if(!file_exists($this->path->Path())){
            $this->Collect(Error::YE200);
            return false;
        }
        $entrylist=array();
	$handle = @opendir($this->path->Path());
	while ($file = @readdir($handle)) {
             if (substr($file, -1)!="." ) {
		$entrylist[]= $file;
             }
        }
        //filter
        if($filter===Yalamo::Fileonly){
            $templist=array();
            foreach ($entrylist as $entry){
                if(is_file($this->path->Path().$entry)){
                    $templist[]=$entry;
                }
                clearstatcache();
            }
            $entrylist=$templist;
        }
        if($filter===Yalamo::Dironly){
            $templist=array();
            foreach ($entrylist as $entry){
                if(is_dir($this->path->Path().$entry)){
                    $templist[]=$entry;
                }
            }
            $entrylist=$templist;
        }
        if((count($entrylist)>0) && ($sort==true)) {
            array_multisort($entrylist, SORT_ASC);
        }
        @closedir($handle);
        return $entrylist;
    }

    private function erase($directory){
        $handle = opendir($directory);
        //traverse all the directories to leave the empty
	while($item = readdir($handle)) {
            //si c'est un repertoire donc l'effacer
            if(is_dir($directory.DS.$item) && substr($item, -2, 2) !== '..' && substr($item, -1, 1) !== '.') {
                $this->erase($directory.DS.$item);
            }
            else{
		if(substr($item, -2, 2) !== '..' && substr($item, -1, 1) !== '.'){
                    unlink($directory.DS.$item);
		}
            }
	}

	$handle = opendir($directory);
        //delete all the directories
	while($item = readdir($handle)) {
            if(is_dir($directory.DS.$item) && substr($item, -2, 2) !== '..' && substr($item, -1, 1) !== '.') {
		$this->erase($directory.DS.$item);
		rmdir($directory.DS.$item);
            }
	}
        if (rmdir($directory)){return true;}else{return false;}
    }


}

