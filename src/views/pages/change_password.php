<?php 
// src/views/pages/change_password.php 
?>

<div class="login-card">
    <h2>Changement de mot de passe</h2>
    <p>C'est votre première connexion. Veuillez définir un nouveau mot de passe sécurisé.</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <?php
            switch ($_GET['error']) {
                case 'mismatch':
                    echo 'Les deux mots de passe ne correspondent pas.';
                    break;
                case 'complexity':
                    echo 'Le mot de passe ne respecte pas les règles de sécurité.';
                    break;
                default:
                    echo 'Une erreur est survenue.';
            }
            ?>
        </div>
    <?php endif; ?>

    <ul class="password-rules">
        <li>Doit contenir au moins 12 caractères </li>
        <li>Doit contenir des majuscules et des minuscules </li>
        <li>Doit contenir des chiffres [cite: 164, 243]</li>
        <li>Doit contenir des caractères spéciaux (ex: ! @ # ?) </li>
    </ul>

    <form action="index.php?action=update_password" method="POST">
        
        <div class="form-group">
            <label for="new_password">Nouveau mot de passe *</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmez le mot de passe *</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn-submit">Valider</button>
    
    </form>
</div>