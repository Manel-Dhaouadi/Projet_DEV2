<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Job.php";
require_once "../app/models/User.php";
require_once "../app/models/Application.php";

class DashboardController extends Controller {

    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $role = $_SESSION['user']['role'];

        if ($role == 'admin') {
            $this->adminDashboard();
        } elseif ($role == 'recruiter') {
            $this->recruiterDashboard();
        } else {
            $this->candidateDashboard();
        }
    }

    private function adminDashboard() {
        $userModel = new User();
        $jobModel = new Job();

        $data = [
            'users' => $userModel->getAllUsers(),
            'jobs' => $jobModel->getAllJobs(),
            'stats' => [
                'totalUsers' => $userModel->countUsers(),
                'totalRecruiters' => $userModel->countByRole('recruiter'),
                'totalCandidates' => $userModel->countByRole('candidate'),
                'totalJobs' => $jobModel->count()
            ]
        ];

        $this->view("dashboard/admin", $data);
    }

    private function recruiterDashboard() {
        $jobModel = new Job();
        $applicationModel = new Application();
        $recruiterId = $_SESSION['user']['id'];

        $data = [
            'jobs' => $jobModel->getJobsByRecruiter($recruiterId),
            'applications' => $applicationModel->getApplicationsByRecruiter($recruiterId),
            'stats' => [
                'totalJobs' => $jobModel->countByRecruiter($recruiterId),
                'totalApplications' => $applicationModel->countByRecruiter($recruiterId),
                'pendingApplications' => $applicationModel->countPendingByRecruiter($recruiterId)
            ]
        ];

        $this->view("dashboard/recruiter", $data);
    }

    private function candidateDashboard() {
        $applicationModel = new Application();
        $candidateId = $_SESSION['user']['id'];

        $data = [
            'applications' => $applicationModel->getApplicationsByCandidate($candidateId),
            'stats' => [
                'totalApplications' => $applicationModel->countByCandidate($candidateId),
                'pending' => $applicationModel->countByCandidateAndStatus($candidateId, 'pending'),
                'accepted' => $applicationModel->countByCandidateAndStatus($candidateId, 'accepted'),
                'rejected' => $applicationModel->countByCandidateAndStatus($candidateId, 'rejected')
            ]
        ];

        $this->view("dashboard/candidate", $data);
    }
}