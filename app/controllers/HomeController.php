<?php 

class HomeController extends Controller{

    public $model_home;
    public $data;
    function __construct(){
        $this->model_home = $this->model("HomeModel");
    }
    function index(){
        $this->data['sub_content']['info']='';
        $this->data['content']= "home/index";
        $this->data['title']='Home page';
        $this->view("layouts/master",$this->data);
    }

}

?>