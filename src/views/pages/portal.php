<?php 
// src/views/pages/portal.php

// Définir le titre de la page (sera utilisé par header.php)
$title = 'Portail de connexion';

// Inclure l'en-tête
require_once ROOT_PATH . '/src/views/templates/header.php'; 

?>

<div class="portal-card">
    <h1>Bienvenue sur la plateforme de feedback</h1>
    
    <ul class="portal-menu">
        
        <li class="portal-menu-item">
            <a href="index.php?action=showLogin&role=student">
                <img src="../public/images/student_icon.png" alt="Icône Étudiant">
                Espace Étudiants
            </a>
        </li>
        
        <li class="portal-menu-item">
            <a href="index.php?action=showLogin&role=trainer">
                <img src="../public/images/teacher_icon.png" alt="Icône Formateur">
                Espace Formateurs
            </a>
        </li>
        
        <li class="portal-menu-item">
            <a href="index.php?action=showLogin&role=admin">
                <img src="../public/images/admin_icon.png" alt="Icône Admin">
                Espace Administration
            </a>
        </li>

    </ul>
</div>

<?php 
require_once ROOT_PATH . '/src/views/templates/footer.php'; 
?>