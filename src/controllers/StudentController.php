<?php

class StudentController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Affiche le formulaire de changement de mot de passe
     */
    public function showChangePasswordForm() {
        // On vérifie que l'utilisateur est bien un étudiant connecté
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student&error=not_logged_in');
            exit;
        }
        
        // Charger la vue
        $title = 'Changement de mot de passe';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        require_once ROOT_PATH . '/src/views/pages/change_password.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }

    /**
     * Traite la soumission du nouveau mot de passe
     */
    public function updatePassword() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student');
            exit;
        }

        $new_password = $_POST['new_password'] ?? null;
        $confirm_password = $_POST['confirm_password'] ?? null;
        $student_id = $_SESSION['user_id'];

        // Vérifier que les mots de passe correspondent
        if ($new_password !== $confirm_password) {
            header('Location: index.php?action=change_password&error=mismatch');
            exit;
        }

        //Vérifier la complexité (Recommandations CNIL)
        // Le mot de passe doit avoir 12+ caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 spécial
        if (strlen($new_password) < 12 ||
            !preg_match('/[A-Z]/', $new_password) ||
            !preg_match('/[a-z]/', $new_password) ||
            !preg_match('/[0-9]/', $new_password) ||
            !preg_match('/[\W_]/', $new_password)) { 
            
            header('Location: index.php?action=change_password&error=complexity');
            exit;
        }

        // Hasher le nouveau mot de passe
        $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        //Mettre à jour la base de données
        $stmt = $this->pdo->prepare(
            "UPDATE Etudiants 
             SET mot_de_passe = ?, premiere_connexion = 0 
             WHERE id = ?"
        );
        $stmt->execute([$new_hashed_password, $student_id]);

        // Rediriger vers le tableau de bord
        header('Location: index.php?action=student_dashboard&password=changed');
        exit;
    }

    /**
     * Affiche le tableau de bord principal de l'étudiant
     */
    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student');
            exit;
        }

        // On inclut le modèle de Feedback pour récupérer l'historique
        require_once ROOT_PATH . '/src/models/Feedback.php';
        $feedbackModel = new Feedback($this->pdo);

        // On récupère les données pour la vue
        $studentEmail = $_SESSION['user_email'];
        $student_id = $_SESSION['user_id'];
        
        //Récupérer l'historique des feedbacks
        $sent_feedbacks = $feedbackModel->getSentFeedback($student_id);

        // Charger la vue
        $title = 'Tableau de Bord Étudiant';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        // On passe $studentEmail ET $sent_feedbacks à la vue
        require_once ROOT_PATH . '/src/views/pages/student_dashboard.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }



    /**
     * Affiche le formulaire de modification du profil
     */
    public function showProfile() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student');
            exit;
        }

        // Récupérer les infos actuelles de l'étudiant
        $stmt = $this->pdo->prepare("SELECT nom, prenom, email FROM Etudiants WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $student_data = $stmt->fetch();

        // Charger la vue
        $title = 'Modifier mon profil';
        require_once ROOT_PATH . '/src/views/templates/header.php';
        // On passe les données de l'étudiant à la vue
        require_once ROOT_PATH . '/src/views/pages/student_profile.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }

    /**
     * Traite la mise à jour du profil
     */
    public function updateProfile() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: index.php?action=showLogin&role=student');
            exit;
        }

        // Récupérer les données du formulaire
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $student_id = $_SESSION['user_id'];


        // Mettre à jour la BDD
        $stmt = $this->pdo->prepare(
            "UPDATE Etudiants SET nom = ?, prenom = ?, email = ? WHERE id = ?"
        );
        $stmt->execute([$nom, $prenom, $email, $student_id]);

        // Mettre à jour l'email dans la session s'il a changé
        if ($email !== $_SESSION['user_email']) {
            $_SESSION['user_email'] = $email;
        }

        // Rediriger vers le tableau de bord avec un message de succès
        header('Location: index.php?action=student_dashboard&profile=updated');
        exit;
    }
}