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
 * @filesource          File.php
 */


/*
 * FILE IMPLEMENTATION
 *
 * Contains the file manipulation/info functionalities
 */
class File extends Object {
    private $path;
    
    public function  __construct($path) {
        $this->path = new Path($path);   
    }
    public function  __toString() {return "Object of Type: File"; }

    public function Extension(){
        $this->path->Extension();
    }
    
    public function Create($content=""){
        $handle=fopen($this->path->Path(),'w');
	if(fwrite($handle,$content)){
            fclose($handle);
            $this->existance=true;
            return true;
	}
	else {
            fclose($handle);
            return false;
	}
    }
    public function Content(){
        if(file_exists($this->path->Path())){
           return file_get_contents($this->path->Path());
        }
        $this->Collect(Error::YE205);
        return false;       
    }
    public function FileMime(){
        return $this->mime;
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE),  $this->path);
    }

    public function Append($content){
        if (file_exists($this->path->Path())){
            $handle=fopen($this->path->Path(),'a');
            fwrite($handle,$content);
            fclose($handle);
            return true;
	}
        $this->Collect(Error::YE205);
        return false;
    }
    
    public function Copy($dest, $overwrite=false){
        if((file_exists($dest)) && ($overwrite==false)){
            return false;
        }
        if (file_exists($this->path->Path())){
          return  @copy($this->path->Path(), $dest);
        }
        $this->Collect(Error::YE205);
        return false;
    }
    public function Delete(){
        if(file_exists($this->path->Path())){
            return  @unlink($this->path->Path());
        }
        $this->Collect(Error::YE205);
        return false;
    } 
    
    private function maxupload(){
       $postmaxsize = trim(ini_get('post_max_size'));
       $unit = strtolower($postmaxsize{strlen($postmaxsize)-1});
       switch($unit) {
           case 'g':
               $postmaxsize *= 1024;
           case 'm':
               $postmaxsize *= 1024;
           case 'k':
               $postmaxsize *= 1024;
       }
       return $postmaxsize;
    }
    public function Upload($files,$allowedmimetypes=array("image/gif","image/png","image/bmp","image/jpg","image/jpeg","text/pdf","text/txt" )){
        if($this->path->IsDirectory()){ $targetfolder=$this->path->Path();}
        echo $targetfolder;
        $maxupload=$this->maxupload();
        if( (!is_array($files)) || (empty($files))){
            $this->Collect(Error::YE107);
            return false;
        }
        $totalfile = count($files['file']['tmp_name']);
	for($i = 0; $i< $totalfile; ++$i){
            if(is_uploaded_file($files['file']['tmp_name'][$i])){
		$name     	= $files['file']['name'][$i];
		$tmp_name 	= $files['file']['tmp_name'][$i];
		$type 		= $files['file']['type'][$i];
		$error   	= $files['file']['error'][$i];
		$clean_name = preg_replace('/[^a-z0-9.-]/', '-', strtolower(basename($name)));

                
		//check for the size
		if($files['file']['size'][$i]<= $maxupload){
                    //check if file mimetype is allowed
                    foreach($allowedmimetypes as $mimetype){
                        if($type==$mimetype){
                            //move the file     
                            if(!move_uploaded_file($tmp_name, $targetfolder.$clean_name)){
                               $this->Collect(Error::YE107);  
                            }
                        }  
                    }
		}
                else{
                    $this->Collect(Error::YE203);
                    return false;
                }
            }
	}
    }  
    public function Download($targetfolder){
        return @copy($this->path->Path(), $targetfolder.$this->path->FileName());
    }
  
}



