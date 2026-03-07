<?php
require_once "../app/core/Model.php";

class Category extends Model {
    protected $table = 'categories';

    public function getAllWithCount() {
        $sql = "SELECT c.*, COUNT(j.id) as job_count 
                FROM categories c 
                LEFT JOIN jobs j ON c.id = j.category_id 
                GROUP BY c.id 
                ORDER BY c.name ASC";
        
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS categories (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            icon VARCHAR(50) DEFAULT 'fa-folder',
            color VARCHAR(20) DEFAULT '#0a66c2',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        return $this->conn->exec($sql);
    }
}