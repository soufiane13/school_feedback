<?php 
// src/views/pages/login.php
?>

<div class="login-card">
    
    <h2><?php echo htmlspecialchars($data['titre']); ?></h2>
    
    <img src="<?php echo htmlspecialchars($data['icone_path']); ?>" alt="Icône" class="login-icon">
    
    <p class="champs-obligatoires">* champs obligatoires</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">Identifiant ou mot de passe incorrect.</div>
    <?php endif; ?>

    <form action="index.php?action=login" method="POST">
        
        <div class="form-group">
            <label for="email">Identifiant *</label>
            <input type="email" id="email" name="email" placeholder="Saisissez votre identifiant." required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe *</label>
            <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe." required>
            </div>
        
        <input type="hidden" name="role" value="<?php echo htmlspecialchars($data['role']); ?>">
        
        <button type="submit" class="btn-submit">Se connecter</button>
    
    </form>
    
    <a href="index.php?action=portal" class="back-link">&larr; Retour au portail</a>
</div>