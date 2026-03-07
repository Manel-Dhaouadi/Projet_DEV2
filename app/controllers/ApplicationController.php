<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Core\Session;

class ApplicationController extends Controller {
    
    private $applicationModel;

    public function __construct() {
        Auth::requireLogin();
        $this->applicationModel = $this->model('Application');
    }

    public function apply() {
        Auth::requireRole('candidate');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jobId = $_POST['job_id'] ?? 0;

            // Upload CV
            if ($_FILES['cv']['type'] !== 'application/pdf') {
                Session::setFlash('danger', 'Le CV doit être au format PDF');
                $this->redirect('?action=job&id=' . $jobId);
            }

            $cvName = time() . '_' . $_FILES['cv']['name'];
            $uploadPath = '../public/uploads/cvs/' . $cvName;
            
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $uploadPath)) {
                $this->applicationModel->apply($jobId, $cvName);
                Session::setFlash('success', 'Candidature envoyée avec succès');
            } else {
                Session::setFlash('danger', 'Erreur lors de l\'upload du CV');
            }

            $this->redirect('?action=myApplications');
        }
    }

    public function myApplications() {
        Auth::requireRole('candidate');

        $data = [
            'applications' => $this->applicationModel->getCandidateApplications()
        ];

        $this->view('applications/index', $data);
    }

    public function manage() {
        Auth::requireRole('recruiter');

        $jobId = $_GET['job_id'] ?? 0;

        if ($jobId) {
            $applications = $this->applicationModel->getJobApplications($jobId);
        } else {
            $applications = $this->applicationModel->getRecruiterApplications();
        }

        $data = [
            'applications' => $applications
        ];

        $this->view('applications/manage', $data);
    }

    public function updateStatus() {
        Auth::requireRole('recruiter');

        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? '';

        $this->applicationModel->updateStatus($id, $status);
        Session::setFlash('success', 'Statut mis à jour');

        $this->redirect('?action=manageApplications');
    }
}