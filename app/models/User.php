<?php
require_once "../app/core/Model.php";

class User extends Model {

    public function create($data) {

        $sql="INSERT INTO users(name,email,password,role,city)
              VALUES(:name,:email,:password,:role,:city)";

        return $this->conn->prepare($sql)->execute($data);
    }

    public function findByEmail($email) {

        $stmt=$this->conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email'=>$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}