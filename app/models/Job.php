<?php
require_once "../app/core/Model.php";

class Job extends Model {
    protected $table = 'jobs';

    public function __construct() {
        parent::__construct();
    }

    // CREATE
    public function create($data) {
        $sql = "INSERT INTO jobs
                (recruiter_id, title, description, type, city, deadline, salary, featured, created_at)
                VALUES
                (:recruiter_id, :title, :description, :type, :city, :deadline, :salary, :featured, :created_at)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // FIND
    public function find($id) {
        $sql = "SELECT j.*, u.name as company_name 
                FROM jobs j 
                JOIN users u ON j.recruiter_id = u.id 
                WHERE j.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $data) {
        $sql = "UPDATE jobs 
                SET title = :title, 
                    description = :description, 
                    type = :type, 
                    city = :city, 
                    deadline = :deadline, 
                    salary = :salary
                WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM jobs WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // SEARCH
    public function search($filters = []) {
        $sql = "SELECT j.*, u.name as company_name 
                FROM jobs j 
                JOIN users u ON j.recruiter_id = u.id 
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND (j.title LIKE :keyword OR j.description LIKE :keyword)";
            $params['keyword'] = "%{$filters['keyword']}%";
        }

        if (!empty($filters['type'])) {
            $sql .= " AND j.type = :type";
            $params['type'] = $filters['type'];
        }

        if (!empty($filters['city'])) {
            $sql .= " AND j.city LIKE :city";
            $params['city'] = "%{$filters['city']}%";
        }

        $sql .= " ORDER BY j.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // COUNT
    public function count($filters = []) {
        $sql = "SELECT COUNT(*) FROM jobs WHERE 1=1";
        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND title LIKE :keyword";
            $params['keyword'] = "%{$filters['keyword']}%";
        }

        if (!empty($filters['type'])) {
            $sql .= " AND type = :type";
            $params['type'] = $filters['type'];
        }

        if (!empty($filters['city'])) {
            $sql .= " AND city = :city";
            $params['city'] = $filters['city'];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchColumn();
        
        return $result ?: 0;
    }

    // COUNT COMPANIES
    public function countCompanies() {
        $sql = "SELECT COUNT(DISTINCT recruiter_id) FROM jobs";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchColumn();
        
        return $result ?: 0;
    }

    // COUNT CANDIDATES
    public function countCandidates() {
        $sql = "SELECT COUNT(*) FROM users WHERE role = 'candidate'";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchColumn();
        
        return $result ?: 0;
    }

    // GET FEATURED JOBS
    public function getFeatured($limit = 3) {
        $sql = "SELECT j.*, u.name as company_name 
                FROM jobs j 
                JOIN users u ON j.recruiter_id = u.id 
                WHERE j.featured = 1 
                ORDER BY j.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET RECENT JOBS
    public function getRecent($limit = 6) {
        $sql = "SELECT j.*, u.name as company_name 
                FROM jobs j 
                JOIN users u ON j.recruiter_id = u.id 
                ORDER BY j.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET ALL JOBS
    public function getAllJobs() {
        $sql = "SELECT j.*, u.name as company_name 
                FROM jobs j 
                JOIN users u ON j.recruiter_id = u.id 
                ORDER BY j.created_at DESC";
        
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET JOBS BY RECRUITER
    public function getJobsByRecruiter($recruiterId) {
        $sql = "SELECT j.*, u.name as company_name 
                FROM jobs j 
                JOIN users u ON j.recruiter_id = u.id 
                WHERE j.recruiter_id = ? 
                ORDER BY j.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$recruiterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // COUNT BY RECRUITER
    public function countByRecruiter($recruiterId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM jobs WHERE recruiter_id = ?");
        $stmt->execute([$recruiterId]);
        return $stmt->fetchColumn();
    }

    // GET STATS
    public function getStats() {
        return [
            'jobs' => $this->count(),
            'companies' => $this->countCompanies(),
            'candidates' => $this->countCandidates(),
            'satisfaction' => 98
        ];
    }

    // PAGINATE
    public function paginate($limit, $offset, $filters = []) {
        $sql = "SELECT jobs.*, users.name AS recruiter
                FROM jobs
                JOIN users ON jobs.recruiter_id = users.id
                WHERE 1=1";

        if (!empty($filters['keyword'])) {
            $sql .= " AND jobs.title LIKE :keyword";
        }

        if (!empty($filters['type'])) {
            $sql .= " AND jobs.type = :type";
        }

        if (!empty($filters['city'])) {
            $sql .= " AND jobs.city = :city";
        }

        $sql .= " ORDER BY jobs.created_at DESC
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);

        if (!empty($filters['keyword'])) {
            $stmt->bindValue(":keyword", "%".$filters['keyword']."%");
        }

        if (!empty($filters['type'])) {
            $stmt->bindValue(":type", $filters['type']);
        }

        if (!empty($filters['city'])) {
            $stmt->bindValue(":city", $filters['city']);
        }

        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}