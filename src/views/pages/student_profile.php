<?php 
// src/views/pages/student_profile.php 
?>

<div class="dashboard-card">
    <h2>Modifier mes informations</h2>
    <p>Mettez à jour vos informations personnelles.</p>

    <form action="index.php?action=update_profile" method="POST" class="profile-form">
        
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($student_data['prenom']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($student_data['nom']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student_data['email']); ?>" required>
        </div>
        
        <button type="submit" class="btn-primary">Enregistrer les modifications</button>
        <a href="index.php?action=student_dashboard" class="back-link" style="margin-top: 16px; display: block;">Annuler</a>
    
    </form>
</div>