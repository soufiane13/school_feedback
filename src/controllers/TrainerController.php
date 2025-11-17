<?php
require_once ROOT_PATH . '/src/models/Module.php';
require_once ROOT_PATH . '/src/models/Feedback.php'; // Pour sauvegarder le feedback

class TrainerController {
    private $pdo;
    private $moduleModel;
    private $feedbackModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->moduleModel = new Module($pdo);
        $this->feedbackModel = new Feedback($pdo);
    }

    /**
     * Affiche le tableau de bord du formateur
     */
    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'trainer') {
            header('Location: index.php?action=showLogin&role=trainer&error=not_logged_in');
            exit;
        }

        $trainer_id = $_SESSION['user_id'];
        $trainerEmail = $_SESSION['user_email'];

        // Récupérer les sessions à noter
        $pending_sessions = $this->moduleModel->getPendingSessionsForTrainer($trainer_id);
        
        // Récupérer l'historique des feedbacks déjà envoyés
        $sent_feedbacks = $this->moduleModel->getSentFeedbackByTrainer($trainer_id);

        //  Charger la vue
        $title = 'Tableau de Bord Formateur';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        // On passe toutes les données à la vue
        require_once ROOT_PATH . '/src/views/pages/trainer_dashboard.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }


    /**
     * Affiche le formulaire de feedback pour le formateur
     */
    public function showFeedbackForm() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'trainer') {
            header('Location: index.php?action=showLogin&role=trainer');
            exit;
        }

        // Récupérer l'ID de la session depuis l'URL
        $session_id = $_GET['session_id'] ?? 0;
        $stmt = $this->pdo->prepare("SELECT m.nom FROM Sessions_Module s JOIN Modules m ON s.id_module = m.id WHERE s.id = ?");
        $stmt->execute([$session_id]);
        $module = $stmt->fetch();
        
        if (!$module) {
            // Rediriger si la session n'existe pas
            header('Location: index.php?action=trainer_dashboard&error=invalid_session');
            exit;
        }
        
        // Charger la vue
        $title = 'Feedback Classe';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        // On passe $session_id et $module à la vue
        require_once ROOT_PATH . '/src/views/pages/trainer_feedback_form.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }

    /**
     * Traite la soumission du feedback du formateur
     */
    public function submitFeedback() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'trainer') {
            header('Location: index.php?action=showLogin&role=trainer');
            exit;
        }

        $trainer_id = $_SESSION['user_id'];
        
        try {
            // On appelle la méthode de sauvegarde du modèle Feedback
            $this->feedbackModel->saveTrainerFeedback($_POST, $trainer_id);
            
            // Succès, redirection vers le tableau de bord
            header('Location: index.php?action=trainer_dashboard&feedback=success');
            exit;

        } catch (Exception $e) {
            header('Location: index.php?action=trainer_dashboard&error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}