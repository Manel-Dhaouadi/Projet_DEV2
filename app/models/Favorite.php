<?php
require_once "../app/core/Model.php";

class Favorite extends Model {

    public function add($job_id,$candidate_id) {
        $stmt=$this->conn->prepare(
            "INSERT INTO favorites(job_id,candidate_id)
             VALUES(:job_id,:candidate_id)"
        );
        return $stmt->execute([
            'job_id'=>$job_id,
            'candidate_id'=>$candidate_id
        ]);
    }

    public function remove($job_id,$candidate_id) {
        $stmt=$this->conn->prepare(
            "DELETE FROM favorites
             WHERE job_id=:job_id AND candidate_id=:candidate_id"
        );
        return $stmt->execute([
            'job_id'=>$job_id,
            'candidate_id'=>$candidate_id
        ]);
    }
}