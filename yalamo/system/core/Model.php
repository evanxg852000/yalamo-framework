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
 *  MODEL IMPLEMENTATION
 *
 * Definition of the model base functionalities
 */



//------------------------------------------------------------------------------
/**
 * Model Class
 *
 * The class that contains the mcv model's  base class
 */
class Model {
    /**
     * Query Object of the model
     *
     * @var Query
     */
    protected $Query;

    /**
     * Represent the database table on which the current Model maps
     * If you use a subclass of Table class this will not serve but if you
     * define this curent model member variables as a map of the Table then you
     * can use is it to generate records.
     * This is the aproach taken in most mvc framework model, but makes the model
     * very tight to a specific Table
     *
     * @var Table
     */
    protected $Table;

    public function  __construct() {
        $this->Query=new Query();
        $this->Table=get_class($this);
    }
    public function  __destruct(){
        unset($this->Query);
    }
    public function  __toString() {return "Object of Type: Model"; }

    /**
     * Set/Get the table of the model
     *
     * @param (Table)Object $table The object of class (table)
     * @return (Table)Object the table of the model
     */
    protected function Table($table=null){
        if(is_null($table)){ return $this->Table; }
        if(is_object($table)){
            $this->Table=get_class($table);
        }
        else{
            $this->Table=$table;
        }
    }

    /**
     * The accessor to the resultset
     *
     * @return array The resultset as an associative array
     */
    protected function ResultSet(){
        return $this->Query->ResultSet();
    }

    /**
     * The accessor to the resultset
     *
     * @return Object The resultset as an object
     */
    protected function ResultObject(){
        return $this->Query->ResultObject();
    }

    /**
     * The accessor to the resultset
     *
     * @return array The resultset an array
     */
    protected function ResultArray(){
        return $this->Query->ResultArray();
    }

    /**
     * The getter for the numbers of rows from the
     * last query
     *
     * @return int The numbers of rows
     */
    protected function NumRows(){
        return $this->Query->NumRows();
    }
    /**
     * Select in the current table of the model from the database
     *
     * @param  string $condition    The conditions in sql statment to be appended to the query
     * @return Object               The resultset as Object
     */
    protected function Select($condition=Yalamo::Void){
        $this->Query->Select($this->Table,Yalamo::All,$condition);
    }

    /**
     * Insert a TableRow in the database
     *
     * @param TableRow $item
     * @return int              The number of rows that was affected
     */
    protected function Insert($item){
        $keys=array_keys($item);
        $values=array_values($item);
        $this->Query->Insert($this->Table, $keys, $values);
        return $this->Query->AffectedRows();
    }

    /**
     * Update record(s) in a database
     *
     * @param array $values         The array of Key=>value pairs to update
     * @param string $condition     The condition  in sql statment to be appended to the query
     * @return <type>
     */
    protected function Update($values, $condition=Yalamo::Void){
        $this->Query->Update($this->Table, $values, $condition);
        return $this->Query->AffectedRows();
    }

    /**
     * Delete record(s) in a database
     *
     * @return int   The number of rows that was affected
     */
    protected function Delete($condition=Yalamo::Void){
        $this->Query->Delete($this->Table, $condition);
        return $this->Query->AffectedRows();
    }
    
}


//------------------------------------------------------------------------------
/**
 * Table Class
 *
 * Base class for table. it's purpose is to create a separation between the model and
 * the abstracte table  from the database. This helps make the model lighter, as well as opening
 * the oportinuity to deal with multiple tables in a single model
 */
abstract  class Table extends Object {

    /**
     * Drop the abstracted table in the database
     */
    public final function Drop(){
      $sql="DROP TABLE ".get_class($this)." ;";
      $db=Database::Instance()->Handle()->Execute($sql);
    }

    /**
     * This method returns the table fields
     *
     * @return array Fields of the table
     */
    public final function Fields(){
        return $this->Properties(false);
    }

    /**
     * Method that brings back a TableRow object on which to create a new row
     * It creates a TableRow by passing the current Object's class
     *
     * @return TableRow   The tableRow Object on which to call Create method
     */
    public function Rows(){
        return new TableRow(get_class($this));
    }

}

/**
 * TableRow Class
 *
 * This class serves as a bridge for every Table subclass and generate a table
 * Row for that subclass.
 * usefull for converting an object of a table (which is an abstraction of the databsae table)
 * into an actual table row usable in an sql Query object (or Database statement)
 * This class shouldn't be use directly. instead use it through The Table Class
 */
final class TableRow {
    /**
     * Table for which to create row
     * @var Object that inherite from table
     */
    private $table;

    /**
     *  Constructor that sets up a table for which to generate a record Row
     *
     * @param string $table Table that we want to create a record of kind
     */
    public function  __construct($table) {
        $this->table=new $table;
    }

    /**
     * Create a table row from an Object that derives from Table
     *
     * @param (Table)Object $object The object that we want to convert into a usable TableRow
     * should be an object of the class passed as parameter
     * @return array
     */
    public function Create($object){
        if(is_object($object)){
            if($object->Fields()==$this->table->Fields()){
                $result=$object->Properties();
                return $result;
            }
        }
        $Inspector =Inspector::Instance();
        $Inspector->Add(Error::YE101,$object);
    }

}
