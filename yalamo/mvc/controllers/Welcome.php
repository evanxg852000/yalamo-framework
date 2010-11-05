<?php 
class Welcome extends Controller {
	
public function Index(){
    $data['title']="Welcom >> Index";
    $data['content']="this is the content of my div from the welcome controller!";
    $this->Load->Module("Database");


    $this->Model=$this->Load->Model('Users');
    //$data["users"]=$this->Model->SelectAll();
   // $this->Model->InsertUser("Evance");

   //$this->Model->Escape();
    

    
    Profiler::CheckPoint("Controller");
    $this->Load->View("index",$data);
    
 
}
	
public function Hello()	{
    $data['title'] = 'Welcome >> Hello';
    $data['content'] = 'wellcome hello content';
    $this->Load->View('Welcome',$data);
}


}




