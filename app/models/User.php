<?php
require_once "../app/core/Model.php";

class User extends Model {
    protected $table = 'users';

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter tous les utilisateurs
    public function countUsers() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    // Compter les utilisateurs par rôle
    public function countByRole($role) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
        $stmt->execute([$role]);
        return $stmt->fetchColumn();
    }

    // Trouver un utilisateur par email
    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un utilisateur
    public function create($data) {
        $sql = "INSERT INTO users (name, email, password, role, city, phone, created_at) 
                VALUES (:name, :email, :password, :role, :city, :phone, NOW())";
        return $this->conn->prepare($sql)->execute($data);
    }

    // Trouver un utilisateur par ID
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ========== METTRE À JOUR UN UTILISATEUR ==========
    public function update($id, $data) {
        $sql = "UPDATE users 
                SET name = :name, 
                    email = :email, 
                    role = :role, 
                    city = :city, 
                    phone = :phone 
                WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Supprimer un utilisateur
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}