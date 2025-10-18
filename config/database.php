<?php
class Database {
    private $host = "ep-rapid-mode-aem0mtdd-pooler.c-2.us-east-2.aws.neon.tech";
    private $db_name = "neondb";
    private $username = "neondb_owner";
    private $password = "npg_ocXrfBN0OY6b";
    private $port = "5432";
    public $conn;

    public function connect() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
            die();
        }
        
        return $this->conn;
    }
}
?>
