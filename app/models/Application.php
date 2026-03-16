<?php
require_once "../app/core/Model.php";

class Application extends Model {
    protected $table = 'applications';

    public function __construct() {
        parent::__construct();
    }

    // ================= APPLY =================
    public function apply($jobId, $userId, $cv, $cv_type = 'text') {
        $sql = "INSERT INTO applications (job_id, user_id, cv, cv_type, status, created_at) 
                VALUES (?, ?, ?, ?, 'pending', NOW())";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$jobId, $userId, $cv, $cv_type]);
    }

    // ================= GET APPLICATIONS BY CANDIDATE =================
    public function getApplicationsByCandidate($userId) {
        $sql = "SELECT a.*, j.title, j.type, j.city, j.id as job_id, u.name as company_name 
                FROM applications a 
                JOIN jobs j ON a.job_id = j.id 
                JOIN users u ON j.recruiter_id = u.id 
                WHERE a.user_id = ? 
                ORDER BY a.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= GET APPLICATIONS BY RECRUITER =================
    public function getApplicationsByRecruiter($recruiterId) {
        $sql = "SELECT a.*, u.name as candidate_name, u.email, j.title as job_title 
                FROM applications a 
                JOIN users u ON a.user_id = u.id 
                JOIN jobs j ON a.job_id = j.id 
                WHERE j.recruiter_id = ? 
                ORDER BY a.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$recruiterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= GET JOB APPLICATIONS =================
    public function getJobApplications($jobId) {
        $sql = "SELECT a.*, u.name as candidate_name, u.email, u.phone 
                FROM applications a 
                JOIN users u ON a.user_id = u.id 
                WHERE a.job_id = ? 
                ORDER BY a.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$jobId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= UPDATE STATUS =================
    public function updateStatus($id, $status) {
        $sql = "UPDATE applications SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // ================= COUNT BY RECRUITER =================
    public function countByRecruiter($recruiterId) {
        $sql = "SELECT COUNT(*) FROM applications a 
                JOIN jobs j ON a.job_id = j.id 
                WHERE j.recruiter_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$recruiterId]);
        return $stmt->fetchColumn();
    }

    // ================= COUNT PENDING BY RECRUITER =================
    public function countPendingByRecruiter($recruiterId) {
        $sql = "SELECT COUNT(*) FROM applications a 
                JOIN jobs j ON a.job_id = j.id 
                WHERE j.recruiter_id = ? AND a.status = 'pending'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$recruiterId]);
        return $stmt->fetchColumn();
    }

    // ================= COUNT BY CANDIDATE =================
    public function countByCandidate($userId) {
        $sql = "SELECT COUNT(*) FROM applications WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    // ================= COUNT BY CANDIDATE AND STATUS =================
    public function countByCandidateAndStatus($userId, $status) {
        $sql = "SELECT COUNT(*) FROM applications WHERE user_id = ? AND status = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $status]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Obtenir la connexion à la base de données
     */
    public function getConnection() {
        return $this->conn;
    }
}