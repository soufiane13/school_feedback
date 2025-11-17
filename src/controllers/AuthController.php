<?php
require_once ROOT_PATH . '/src/models/User.php';

class AuthController {
    private $pdo;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }


    public function showLogin() {
        //  Récupérer le rôle depuis l'URL (student, trainer, admin)
        $role = $_GET['role'] ?? 'student'; // 'student' par défaut
        
        // Préparer les données dynamiques pour la vue
        $data = [];
        switch ($role) {
            case 'student':
                $data['titre'] = 'Espace Étudiants';
                $data['icone_path'] = '../public/images/student_icon.png';
                break;
            case 'trainer':
                $data['titre'] = 'Espace Enseignants';
                $data['icone_path'] = '../public/images/teacher_icon.png';
                break;
            case 'admin':
                $data['titre'] = 'Espace Administration';
                $data['icone_path'] = '../public/images/admin_icon.png';
                break;
            default:
                // Si le rôle est inconnu, on redirige vers le portail
                header('Location: index.php?action=portal');
                exit;
        }
        
        // Garder le rôle pour le formulaire
        $data['role'] = $role;

        //  Charger la vue de connexion et lui passer les données
        $title = $data['titre']; // Pour le header
        require_once ROOT_PATH . '/src/views/templates/header.php';
        require_once ROOT_PATH . '/src/views/pages/login.php';
        require_once ROOT_PATH . '/src/views/templates/footer.php';
    }

    public function login() {
        //  Récupérer les données du formulaire (POST)
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $role = $_POST['role'] ?? null;

        // Nettoyer le mot de passe du formulaire
        $password_from_form = trim($password);

        // Trouver l'utilisateur
        $user = $this->userModel->findByEmailAndRole($email, $role);

        // Initialiser la variable de succès
        $login_success = false;

        // Vérifier l'utilisateur ET le mot de passe
        if ($user) {
            // On ne vérifie le hash que si l'utilisateur existe
            $hash_from_db = trim($user['mot_de_passe']);
            
            if (password_verify($password_from_form, $hash_from_db)) {
                $login_success = true;
            }
        }

        // Gérer le résultat
        if ($login_success) {
            // Succès ! On crée la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $role;

            // Gérer la redirection
            if ($role === 'student') {
                
                if ($user['premiere_connexion'] == 1) {
                    header('Location: index.php?action=change_password');
                    exit;
                }
                // Redirection normale
                header('Location: index.php?action=student_dashboard');
                exit;
            }
            
            if ($role === 'trainer') {
                header('Location: index.php?action=trainer_dashboard');
                exit;
            }

            if ($role === 'admin') {
                header('Location: index.php?action=admin_dashboard');
                exit;
            }
            
            header('Location: index.php?action=portal'); 
            exit;

        } else {
            header('Location: index.php?action=showLogin&role=' . $role . '&error=1');
            exit;
        }
    }
    
    /**
     * Déconnecte l'utilisateur
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?action=portal&logout=success');
        exit;
    }
}