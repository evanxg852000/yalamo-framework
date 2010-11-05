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
 * CORE IMPLEMENTATION
 *
 * Contains the base class implementation and very usefull constants that form
 * the back bone of the framework
 *
 */

//------------------------------------------------------------------------------
/**
 * Yalamo Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
final class Yalamo {
    const  None         = 0;
    const  Unic         = 1;
    const  Double       = 2;

    const  Mvc          ="Mvc";
    const  Classic      ="Classic";
    const  Pogsql       = "POSTGRESQL";
    const  Mysql        = "MYSQL";
    const  Sqlite       = "SQLITE";

    const  Void         ="";
    const  Space        =" ";
    const  All          ="*";
    const  Endline      ="\n";
    const  Tab          ="\t";
    const  Fileonly     ="Fo";
    const  Dironly      ="Do";

    const  Ds       =DS;
   
    /**
     * Loads the files contained in the $AutoLoadArray array
     * @param array $AutoLoadArray The User defined array
     */
    public static function  Autoload($AutoLoadArray){
      $load=new Loader();
      $load->Modules($AutoLoadArray['modules']);
      $load->Helpers($AutoLoadArray['helpers']);
      $load->Extensions($AutoLoadArray['extensions']);
    }
    
}


//------------------------------------------------------------------------------
/**
 * Loader Class
 *
 * The class that contains the framework enumeration and static methods
 * to do useful thing.
 */
final class Loader {
    public function  __construct() {}
    public function  __destruct() {}
    public function  __toString() {return "Object of Type: Loader"; }

    /**
     * Loads a Module from the modules directory
     *
     * @param string $module The module name
     */
    public function Module($module){
        $fullpath=YMODULEDIR.ucwords($module).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads a Helper from the helpers directory
     *
     * @param string $helper the helper name
     */
    public function Helper($helper){
        $fullpath=YHELPERSDIR.ucwords($helper).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads an Extension from the Extensions directory
     *
     * @param string $extension The extension name
     */
    public function Extension($extension){
        $fullpath=YEXTENTIONDIR.ucwords($extension).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads a Model from the mvc models directory and instanciate it
     *
     * @param string $model The model name
     * @return Model        An instance of the loade model
     */
    public function Model($model){
        $fullpath=MVCPATH."models".DS.ucwords($model).EXT;
        $this->Load($fullpath);
        return new $model();
    }

    /**
     * Loads a view from the mvc views directory
     *
     * @param string $view  The view name
     * @param mixed  $data  The optional data to be passed in
     */
    public function View($view,$data=Null){
        $fullpath=MVCPATH."views".DS.ucwords($view).EXT;
        $this->Load($fullpath,$data);
    }

    /**
     * Loads a Controller from the mvc controllers directory
     *
     * @param string $controller The controller name
     */
    public function Controller($controller){
        $fullpath=MVCPATH."controllers".DS.ucwords($controller).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads a page from the site root  directory in classic mode
     *
     * @param string $page  The page name
     */
    public function Page($page){
        $fullpath=ucwords($page).EXT;
        $this->Load($fullpath);
    }

    /**
     * Loads Modules from the modules directory
     * @param array $modules The names of the modules
     */
    public function Modules($modules){
       foreach($modules as $module ){
          $this->Module($module);
       }
    }

     /**
     * Loads Helpers from the helpers directory
      *
     * @param array $helpers The names of the helpers
     */
    public function Helpers($helpers){
       foreach($helpers as $helper ){
          $this->Helper($helper);
       }
    }

    /**
     * Loads Extensions from the Extensions directory
     *
     * @param array $extensions The names of the extensions
     */
    public function Extensions($extensions){
       foreach($extensions as $extension ){
          $this->Extension($extension);
       }
    }

    /**
     * Load a php file from any path specified. return false if not found
     *
     * @param string $fullpath
     * @param mixe $data  The  data to be passed in
     * @return false|null
     */
    private function  Load($fullpath, $data=null){
        global $Alias;  
        if(ENABLEALIAS){ //convert alias array into variable
           foreach ($Alias as $key => $val){
                    $$key = $val;
               }
        }
        if( $data!=null){ //convert $data into variables by: var var trick
            if(is_array($data)){
               foreach ($data as $key => $val){
                    $$key = $val;
               }
            }
        }
        if(file_exists($fullpath)){
            require_once ($fullpath);
        }
        else{
            return false;
        }

    }

}

//------------------------------------------------------------------------------
/**
 * Php internal auto loading
 *
 * @param string $classname The name of the class that's trying to be instanciated
 */
function __autoload($classname){
   $load=new Loader();
   $load->Module($classname);
}


//------------------------------------------------------------------------------
/**
 * ISerialisable Interface
 *
 * The Interface for serialisable object.
 */
interface ISerialisable {
    public function Serialize();
    public function Unserialize($object);
}

//------------------------------------------------------------------------------
/**
 * Abstract Class ICollectable 
 *
 * Every class that raise yalamo error to be collected by the Inspector
 * should implement to get more hierarchical capabilities
 * is actually an Interface but for the reason that Php only allow Public methods
 * in interfaces it is declared as an abstract class
 */
abstract class ICollectable{
    abstract protected function Collect($errortype);
    abstract protected function PCollect($errortype,$subject);
}

//------------------------------------------------------------------------------
/**
 * Object Class
 *
 * The base Object of classes that want to use base functionalities without
 * implementing base interfaces
 */
class Object  extends ICollectable implements ISerialisable {

    /**
     * The serialise method 
     * @return string The Object in string format
     */
    public function Serialize(){
        return serialize($this);
    }

    /**
     *
     * @param  string $Object   The object in string format
     * @return Object           The object in pure Object format
     */
    public function Unserialize($Object){
        return (Object) unserialize($Object);
    }

    /**
     *
     * This method use reflexion to return an associated array of the class' members
     * and their value
     *
     * @param bool $visible  If set to false, only the class' members will be returned
     * @return array Members of the class
     */
    public function Properties($visible=true){
        $reflection=new ReflectionClass($this);
        $properties=$reflection->getProperties();
        $result=array();
        if($visible){
            foreach ($properties as $property) {
                $result[$property->getName()]=$property->getValue($this);
            }
        }
        else{
            foreach ($properties as $property) {
                $result[]=$property->getName();
            }
        }
        return $result;
    }

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

}


//------------------------------------------------------------------------------
/**
 * Profiler Class
 *
 * The class to benchmarke the application speed
 */
final class Profiler extends Object{
    public static $instance=NULL;
    private $checkpoints;

    private function  __construct() {}
    private function  __clone() {}
    private function process($previous, $next){
         $str=Yalamo::Void;
         $str .="<tr>";
		$str .="<td class=\"checkpoint\">".$previous['Name']."</td>";
		$str .="<td class=\"checkpoint\">".$next['Name']."</td>";

		$str .="<td>".round($previous['Time'],3)."</td>";
		$str .="<td>".round($next['Time'],3)."</td>";
                $v=round($next['Time']-$previous['Time'],3);
		$str .="<td class=\"delta\">".$v."</td>";

		$str .="<td>".$previous['EMemory']."</td>";
		$str .="<td>".$next['EMemory']."</td>";
                $v=$next['EMemory']-$previous['EMemory'];
		$str .="<td class=\"delta\">".$v."</td>";

		$str .="<td>".$previous['RMemory']."</td>";
		$str .="<td>".$next['RMemory']."</td>";
                $v=$next['RMemory']-$previous['RMemory'];
		$str .="<td class=\"delta\">".$v."</td>";
	$str .="</tr>";
         return $str;
    }
    private function analyse($start, $end) {
        $html='
                <style type="text/css">
                    table#profileanalyse {
                            border:solid 1px #918e8e;
                            text-align:center;
                            border-spacing:1px;
                            font-family:calibri ;
                    }

                    table#profileanalyse td {
                            border: solid  1px #918e8e;
                            padding: 3px;
                            text-align:center;

                    }

                    table#profileanalyse th {
                            background-color: #8dc4fc;
                            border: solid  1px #918e8e;
                            padding: 3px;
                    }
                    table#profileanalyse .subth {
                            background-color: #d2e1f4;
                            border: solid  1px #918e8e;
                            padding: 3px;
                            font-style:italic;
                    }
                    table#profileanalyse .delta {
                          color: #8cc75f;
                          font-weight:bold;
                    }
                    table#profileanalyse .checkpoint {
                            background-color: #8cb73f;
                            border: solid  1px #918e8e;
                            padding: 3px;
                            font-style:italic;
                            font-weight:bold;
                    }
                </style>
                <table id="profileanalyse">
                <tr>
                    <th colspan="2">Check Point</th>
                    <th colspan="3">Time (s)</th>
                    <th colspan="3">Memory Emalloc (ko)</th>
                    <th colspan="3">Memory Real (ko)</th>
                </tr>
                <tr class="subth">
                    <td>From</td>
                    <td>To</td>

                    <td>Begin</td>
                    <td>End</td>
                    <td>Delta</td>

                    <td>Begin</td>
                    <td>End</td>
                    <td>Delta</td>

                    <td>Begin</td>
                    <td>End</td>
                    <td>Delta</td>
                </tr>';
        if(($start==Yalamo::All)||($end==Yalamo::All)){
            $nbcpt=count($this->checkpoints);
            for($i=0;$i<$nbcpt-1;$i++){
                $html .=$this->process($this->checkpoints[$i],$this->checkpoints[$i+1]);
            }
        }
        else {
            if((!array_key_exists($start, $this->checkpoints)) || (!array_key_exists($end, $this->checkpoints))){
                $this->Collect(Error::YE100);
                return false;
            }
            //process here
        }
        $html .=$this->process($this->checkpoints[0], $this->checkpoints[count($this->checkpoints)-1]);
        $html .="</table>";
        return $html;
    }
    private function kbyte($m){ return @round($m/1024,2); }

    public static function Instance(){
        if(!self::$instance)
        {
            self::$instance=new Profiler();
        }
        return self::$instance;
    }
    public static function CheckPoint($name){
        $ProfilerObject=  Profiler::Instance();
        $ProfilerObject->checkpoints[]=array(
            "Name"=>$name,
            "Time"=>microtime(true),
            "EMemory"=>  $ProfilerObject->kbyte(memory_get_usage()),
            "RMemory"=>  $ProfilerObject->kbyte(memory_get_usage(true))
        );
    } 
    public static function Profile($start=Yalamo ::All, $end=Yalamo::All){
        $ProfilerObject=  Profiler::Instance();
        return $ProfilerObject->analyse($start, $end);
    }
    
}