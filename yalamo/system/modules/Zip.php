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
 * @filesource          Zip.php
 */

/*
 * Zip IMPLEMENTATION
 *
 * Contains compression functionalities for zip format
 */

//------------------------------------------------------------------------------
/**
 * Zip Class
 *
 * Define methods for manipulation and creating zip file
 */
class Zip extends Object{
	
	private $handlezip;
	private $sourcefolder;
        private $filename;        
        const extension=".zip";
  


        public function __construct($sourcefolder,$filename){
           $sourcefolder=new Path($sourcefolder);
           $this->sourcefolder = $sourcefolder->Path();
           $this->filename=$filename.Zip::extension;
           $this->handlezip = new ZipArchive();
	}
	public function __tostring(){ return "Object of Type: Zip";}

	public function Create($defaultfolder=Yalamo::Void){
            if ($this->handlezip->open( $this->sourcefolder.$this->filename, ZipArchive::CREATE) === true){
                if($defaultfolder==Yalamo::Void){
                    $defaultfolder= str_replace(Zip::extension,  Yalamo::Void, $this->filename);
                }
                $this->handlezip->addEmptyDir($defaultfolder);
                $this->handlezip->close();
                return true;
            }
            $this->Collect(Error::YE100);
            return false;
	}

        public function AddFiles($filelist,$zippedfolder=Yalamo::Void){           
            if(!is_array($filelist)){
                $this->Collect(Error::YE100);
                return;
            }
            if ( $this->handlezip->open($this->sourcefolder.$this->filename)===true) {
                foreach ($filelist as $file){
                     $this->handlezip->addFile($this->sourcefolder.$file,$zippedfolder.DS.$file );
                }
                $this->handlezip->close();
                return true;
            }
            $this->Collect(Error::YE001);
            return false;
	}
        public function AddFolder($folder){
           if ($this->handlezip->open( $this->sourcefolder.$this->filename, ZipArchive::CREATE) === true){
                $this->handlezip->addEmptyDir($folder);
                $this->handlezip->close();
                return true;
            }
            $this->Collect(Error::YE100);
            return false;
        }


        public function ArchiveFolder($folder){
            if(!is_dir($this->sourcefolder.$folder)){
                $this->Collect(Error::YE100);
                return;
            }
            $this->Create($folder); 
            $dir=new Dir($this->sourcefolder.$folder);
            $filelist=$dir->Entries(Yalamo::Fileonly);
            //if ($this->AddFiles((array)$filelist,$folder)){
             //   return true;
           // }
            if ( $this->handlezip->open($this->sourcefolder.$this->filename)===true) {
                foreach ($filelist as $file){
                     $this->handlezip->addFile($this->sourcefolder.$folder.DS.$file,$folder.DS.$file );
                echo $this->sourcefolder.$folder.DS.$file;

                }
                $this->handlezip->close();
                return true;
            }
            $this->Collect(Error::YE001);
            return false;
	}

        public function ExtractFiles($destination){
           if ($this->handlezip->open($this->sourcefolder.$this->filename)===true){
                $this->handlezip->extractTo($destination);
		$this->handlezip->close();
                return true;
           }
           $this->Collect(Error::YE100);
           return false;
	}
	public function DeleteArchive(){
            if (unlink($this->sourcefolder.$this->filename)){
		return true;
            }
            $this->Collect(Error::YE100);
            return false;
	}       
	

        
}

