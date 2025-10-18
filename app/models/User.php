<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (nama_lengkap, email, password, nomor_telepon, provinsi, kota, foto_profil, tanda_tangan) 
                  VALUES (:nama_lengkap, :email, :password, :nomor_telepon, :provinsi, :kota, :foto_profil, :tanda_tangan)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':nomor_telepon', $data['nomor_telepon']);
        $stmt->bindParam(':provinsi', $data['provinsi']);
        $stmt->bindParam(':kota', $data['kota']);
        $stmt->bindParam(':foto_profil', $data['foto_profil']);
        $stmt->bindParam(':tanda_tangan', $data['tanda_tangan']);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_lengkap = :nama_lengkap, 
                      email = :email, 
                      nomor_telepon = :nomor_telepon, 
                      provinsi = :provinsi, 
                      kota = :kota";
        
        if(!empty($data['password'])) {
            $query .= ", password = :password";
        }
        if(!empty($data['foto_profil'])) {
            $query .= ", foto_profil = :foto_profil";
        }
        if(!empty($data['tanda_tangan'])) {
            $query .= ", tanda_tangan = :tanda_tangan";
        }
        
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':nomor_telepon', $data['nomor_telepon']);
        $stmt->bindParam(':provinsi', $data['provinsi']);
        $stmt->bindParam(':kota', $data['kota']);
        
        if(!empty($data['password'])) {
            $stmt->bindParam(':password', $data['password']);
        }
        if(!empty($data['foto_profil'])) {
            $stmt->bindParam(':foto_profil', $data['foto_profil']);
        }
        if(!empty($data['tanda_tangan'])) {
            $stmt->bindParam(':tanda_tangan', $data['tanda_tangan']);
        }
        
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function checkEmailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
