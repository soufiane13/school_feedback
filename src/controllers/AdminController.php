<?php
// src/controllers/AdminController.php

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function dashboard() {
        // --- SÉCURITÉ OBLIGATOIRE ---
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: index.php?action=showLogin&role=admin&error=not_logged_in');
            exit;
        }

        $adminEmail = $_SESSION['user_email'];

        // Inclure les modèles
        require_once ROOT_PATH . '/src/models/Feedback.php';
        require_once ROOT_PATH . '/src/models/Admin.php';
        
        $feedbackModel = new Feedback($this->pdo);
        $adminModel = new Admin($this->pdo);

        // Récupérer les filtres actifs 
        $filters = [
            'id_classe' => $_GET['id_classe'] ?? null,
            'id_module' => $_GET['id_module'] ?? null,
            'id_etudiant' => $_GET['id_etudiant'] ?? null
        ];

        // Récupérer TOUS les feedbacks, en appliquant les filtres
        $all_feedbacks = $feedbackModel->getAllFeedbacks($filters);

        // Récupérer les listes pour remplir les menus déroulants
        $filter_lists = [
            'classes' => $adminModel->getAllClasses(),
            'modules' => $adminModel->getAllModules(),
            'students' => $adminModel->getAllStudents()
        ];

        // Charger la vue
        $title = 'Tableau de Bord Admin';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        // On passe toutes les données à la vue
        require_once ROOT_PATH . '/src/views/pages/admin_dashboard.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }
}