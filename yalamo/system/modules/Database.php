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
 * @filesource          Database.php
 */

/*
 * DATABASE IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

//------------------------------------------------------------------------------
/**
 * Databases Class
 *
 * The class that contains the implementation of manipulating and handling a database
 * during the application life cycle for performence reason, it has been made singleton
 * if you whish to manipulate many connections you should use the databse driver instead
 *
 */
final class Database {
    private static $instance=NULL;
    private $driverObject;
    private function   __construct() {
        switch(DBDRIVER){
		case Yalamo::Mysql:
                   $this->driverObject=new Mysql();
                break;
                case Yalamo::Sqlite:
                   $this->driverObject=new Sqlite();
                break;
                case Yalamo::Pogsql:
                    $this->driverObject=new Pogsql();
		break;
            }
    }
    private function   __clone() {}
    
    public static function Instance(){
        if(!self::$instance){
            self::$instance=new Database();
        }
        return self::$instance;
    }    

    public function Handle(){
        return $this->driverObject;
    }
    public function Connection(){;
        return $this->driverObject->Connection();
    }
    public function Create($name){
      return $this->driverObject->Create($name);
    }
    public function Drop($name){
      return $this->driverObject->Delete($name);
    }
    public function Export($name){
       return $this->driverObject->Export($name);
    }
    public function Databases(){
       return $this->driverObject->Databases();
    }    
}

//------------------------------------------------------------------------------
/**
 * DBDriver Class
 *
 * The abstract Base Class for Databases Driver. any supported database engine should extends this class
 */
abstract  class DBDriver extends ICollectable {
    protected  $connection;
    protected  $result;
    
    /**
     * The methode that makes a derived class collectable by the inspector
     * and provide for that reason an easy way to raise error on that object
     *
     * @param Error::Enum $errortype
     */
    protected function Collect($errortype) {
        $inspector=Inspector::Instance();
        $inspector->Add($errortype,  $this);
    }
    
    /**
     * The P means Personalised which helps passed a specific object rather that the
     * Top level object
     *
     * @param Error::Enum $errortype
     * @param mixed $subject
     */
    protected function PCollect($errortype,$subject){
        $inspector=Inspector::Instance();
        $inspector->Add($errortype,  $subject);
    }
    
    public abstract function  __construct();
    public abstract function  __destruct();

    public abstract function Connection();
    public abstract function Create($name);
    public abstract function Drop($name);
    public abstract function Export($file);
    public abstract function Databases();

    public abstract function Escape($vars);
    public abstract function Prepare($sql,$data);

    public abstract function Execute($sql);
    public abstract function Select($table,$fields=Yalamo::All,$condition=Yalamo::Void);
    public abstract function Insert($table,$keys,$values,$single=true);
    public abstract function Update($table,$values,$condition=Yalamo::Void);
    public abstract function Delete($table,$condition=Yalamo::Void);

    public abstract function ResultObject();
    public abstract function ResultSet();
    public abstract function ResultArray();
    
    public abstract function Fields();
    public abstract function NumRows();
    public abstract function AffectedRows();

}

