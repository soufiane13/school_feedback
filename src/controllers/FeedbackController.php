<?php
require_once ROOT_PATH . '/src/models/Feedback.php';

class FeedbackController {
    private $pdo;
    private $feedbackModel; 

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->feedbackModel = new Feedback($pdo); 
    }

    /**
     * Affiche le formulaire de feedback
     */
    public function showForm() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student');
            exit;
        }


        // On récupère les VRAIS modules que l'étudiant peut noter
        $student_id = $_SESSION['user_id'];
        $available_modules = $this->feedbackModel->getPendingModules($student_id);

        // Charger la vue
        $title = 'Donner un feedback';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        require_once ROOT_PATH . '/src/views/pages/feedback_form.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }

    /**
     * Traite la soumission du formulaire
     */
    public function submit() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student');
            exit;
        }
        
        // On récupère l'ID de l'étudiant depuis la session (plus sécurisé)
        $student_id = $_SESSION['user_id'];
        
        try {
            // On appelle la méthode save() de notre modèle
            $this->feedbackModel->save($_POST, $student_id);
            
            // Si c'est un succès, on redirige vers le tableau de bord
            header('Location: index.php?action=student_dashboard&feedback=success');
            exit;

        } catch (Exception $e) {
            header('Location: index.php?action=feedback_form&error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}