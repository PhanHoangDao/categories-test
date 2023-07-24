<?php 

class Database{
    public $conn;

    public function getConnection()
    {
        global $config;
    
        $configDB=$config['database'];
        try {
            $this->conn = new PDO(
                "mysql:host=" . $configDB['host'] . ";dbname=" . $configDB['db'],
                $configDB['user'],
                $configDB['password']
            );
            // Đặt chế độ lỗi và ngoại lệ cho PDO
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
            return null;
        }
    }
}

?>