<?php 


class  App
{

    private $controller, $action="index", $params=[];
    
    public function __construct(){
        global $routes;
        if(!empty($routes['default_controller'])){
            $this->controller = $routes['default_controller'];
        }
        $this->action="index";
        $this->params=[];
        $this->handleUrl();
    }

    public function getUrl(){
        if(!empty($_SERVER['PATH_INFO'])){
            $url= $_SERVER['PATH_INFO'];
        }else{
            $url='/';
        }
        return $url;
    }

    public function handleUrl(){
        $url = $this->getUrl();
        $urlArr= array_filter(explode("/",strtolower($url)));
        $urlArr= array_values($urlArr);

        //handle controller
        if(!empty($urlArr[0])){
            $this->controller=ucfirst($urlArr[0]);
        }else{
            $this->controller=ucfirst($this->controller);
        }
        $file_path='app/controllers/'.$this->controller.'Controller.php';
        if(file_exists($file_path)){
            require_once 'controllers/'.$this->controller.'Controller.php';
            $this->controller= $this->controller.'Controller';
            if(class_exists($this->controller)){
                $this->controller=new $this->controller();
                unset($urlArr[0]);
            }else{
                $this->loadError();
            }
        }else{
            $this->loadError();
        }

        //handle action
        if(!empty($urlArr[1])){
            $this->action=$urlArr[1];
            unset($urlArr[1]);
        }
        //handle parameters
        $this->params=array_values($urlArr);

        if(method_exists($this->controller,$this->action)){

            call_user_func_array([$this->controller,$this->action],$this->params);
        }else{
            $this->loadError();
        }


    }
    public function loadError($error=404){
        require_once 'errors/'.$error.'.php';
    }
}
    


?>