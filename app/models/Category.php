<?php
require_once "../app/core/Model.php";

class Category extends Model {
    protected $table = 'categories';

    // Récupérer toutes les catégories
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les catégories avec le nombre d'offres
    public function getAllWithCount() {
        $sql = "SELECT c.*, COUNT(j.id) as job_count 
                FROM categories c 
                LEFT JOIN jobs j ON c.id = j.category_id 
                GROUP BY c.id 
                ORDER BY c.name ASC";
        
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une catégorie par ID
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter une catégorie
    public function create($data) {
        $sql = "INSERT INTO categories (name, icon, color, created_at) 
                VALUES (:name, :icon, :color, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Modifier une catégorie
    public function update($id, $data) {
        $sql = "UPDATE categories 
                SET name = :name, icon = :icon, color = :color 
                WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Supprimer une catégorie
    public function delete($id) {
        // Vérifier si des offres utilisent cette catégorie
        $check = $this->conn->prepare("SELECT COUNT(*) FROM jobs WHERE category_id = ?");
        $check->execute([$id]);
        $count = $check->fetchColumn();
        
        if ($count > 0) {
            $_SESSION['error'] = "Impossible de supprimer : {$count} offre(s) utilisent cette catégorie";
            return false;
        }
        
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtenir les icônes disponibles
    public function getAvailableIcons() {
        return [
            'fa-code', 'fa-chart-line', 'fa-handshake', 'fa-chart-pie',
            'fa-users', 'fa-truck', 'fa-file-alt', 'fa-bullhorn',
            'fa-laptop', 'fa-database', 'fa-paint-brush', 'fa-camera',
            'fa-stethoscope', 'fa-gavel', 'fa-leaf', 'fa-flask'
        ];
    }

    // Obtenir les couleurs disponibles
    public function getAvailableColors() {
        return [
            '#0a66c2', '#10b981', '#f59e0b', '#8b5cf6',
            '#ec4899', '#14b8a6', '#f97316', '#6b7280',
            '#3b82f6', '#ef4444', '#06b6d4', '#a855f7'
        ];
    }
}