<?php 

class HomeModel extends Model{

    public function __construct(){
        parent::__construct();
    }
    public function getList(){
        try {
            $statement= $this->db->prepare('select * from categories');
            $statement->execute();
            $result= $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return null;
    }
    
}

?>