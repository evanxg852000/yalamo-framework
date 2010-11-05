<?php
class Users extends Model {
    public function  __construct() {
        parent::__construct();
    }

    public function InsertUser($name){
        $u=new User();
        $u->id=null;
        $u->name=$name;

        $item=$u->Rows()->Create($u);
        parent::Insert($item);
    }
    public function SelectAll(){
        parent::Select();
        return $this->ResultObject();
    }
    public function Escape(){
        $vars="evance'soumaor \nis fiek ";
        echo  $this->Query->Escape($vars);
        echo $this->Query->Prepare("SELECT* FROM Table Where Name={name} AND Age={age} ", array("name"=>"evan'ce","age"=>56));

    }

}

class User extends Table{
    public $id;
    public $name;
}