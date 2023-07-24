<?php 
    define('_DIR_ROOT',__DIR__);
    $configs_dir=scandir('configs');
   
    if(!empty($configs_dir)){
        foreach($configs_dir as $item){
            if($item!='.' && $item!='..' && file_exists('configs/'.$item)){
                require_once './configs/'.$item;
               
        }
    }
    if(!empty($config['database'])){
        $db_config= array_filter($config['database']);
        if(!empty($db_config)){
            require_once './core/Database.php';
}
        }
    }
    require_once './configs/routes.php';
    require_once './app/App.php';
    require_once './core/Model.php';
    require_once './core/Controller.php';
    
?>