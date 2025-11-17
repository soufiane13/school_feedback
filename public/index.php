<?php
// public/index.php

session_start();
require_once __DIR__ . '/../config/database.php';
define('ROOT_PATH', dirname(__DIR__));

// 4. Système de Routage 
$action = $_GET['action'] ?? 'portal';

switch ($action) {
    
    case 'portal':
        require_once ROOT_PATH . '/src/views/pages/portal.php';
        break;

    case 'showLogin':
        require_once ROOT_PATH . '/src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->showLogin(); 
        break;

    case 'login':
        require_once ROOT_PATH . '/src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;

    case 'logout':
        require_once ROOT_PATH . '/src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;


    case 'student_dashboard':
        require_once ROOT_PATH . '/src/controllers/StudentController.php';
        $controller = new StudentController($pdo);
        $controller->dashboard();
        break;
    
        case 'show_profile':
            require_once ROOT_PATH . '/src/controllers/StudentController.php';
            $controller = new StudentController($pdo);
            $controller->showProfile();
            break;
    
        case 'update_profile':
            require_once ROOT_PATH . '/src/controllers/StudentController.php';
            $controller = new StudentController($pdo);
            $controller->updateProfile();
            break;    

    
        case 'feedback_form':
        require_once ROOT_PATH . '/src/controllers/FeedbackController.php';
        $controller = new FeedbackController($pdo);
        $controller->showForm();
        break;

    case 'submit_feedback':
        require_once ROOT_PATH . '/src/controllers/FeedbackController.php';
        $controller = new FeedbackController($pdo);
        $controller->submit();
        break;

    case 'change_password':
        require_once ROOT_PATH . '/src/controllers/StudentController.php';
        $controller = new StudentController($pdo);
        $controller->showChangePasswordForm();
        break;

    case 'update_password':
        require_once ROOT_PATH . '/src/controllers/StudentController.php';
        $controller = new StudentController($pdo);
        $controller->updatePassword();
        break;


    case 'trainer_dashboard':
        require_once ROOT_PATH . '/src/controllers/TrainerController.php';
        $controller = new TrainerController($pdo);
        $controller->dashboard();
        break;
     
        case 'admin_dashboard':
            require_once ROOT_PATH . '/src/controllers/AdminController.php';
            $controller = new AdminController($pdo);
            $controller->dashboard();
            break;    
    
        
        case 'show_trainer_feedback':
            require_once ROOT_PATH . '/src/controllers/TrainerController.php';
            $controller = new TrainerController($pdo);
            $controller->showFeedbackForm();
            break;
    
        case 'submit_trainer_feedback':
            require_once ROOT_PATH . '/src/controllers/TrainerController.php';
            $controller = new TrainerController($pdo);
            $controller->submitFeedback();
            break;    
    
    default:
        echo "Erreur 404 - Page non trouvée";
        break;
}