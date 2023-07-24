<?php 

class Model{

    protected $db;
    public function __construct(){
        $this->db=new Database();
        $this->db=$this->db->getConnection();
        return $this->db;
    }
}

?>