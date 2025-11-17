<?php 
// src/views/pages/student_dashboard.php 
?>

<div class="dashboard-card">
    
    <?php if (isset($_GET['password']) && $_GET['password'] === 'changed'): ?>
        <div class="success-message">
            Votre mot de passe a été mis à jour avec succès !
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['feedback']) && $_GET['feedback'] === 'success'): ?>
        <div class="success-message">
            Votre feedback a été enregistré avec succès. Merci !
        </div>
    <?php endif; ?>

    <h2>Tableau de Bord Étudiant</h2>
    
    <p>Bienvenue, <strong><?php echo htmlspecialchars($studentEmail); ?></strong> !</p>
    
    <div class="dashboard-sections">
        
        <div class="dashboard-section">
            <h3>Feedbacks en cours</h3>
            <p>C'est ici que vous verrez les modules récents que vous pouvez noter.</p>
            <a href="index.php?action=feedback_form" class="btn-primary">Donner un nouveau feedback</a>
        </div>

        <div class="dashboard-section">
            <h3>Mes feedbacks envoyés</h3>
            
            <?php if (empty($sent_feedbacks)): ?>
                <p>Vous n'avez pas encore envoyé de feedback.</p>
            <?php else: ?>
                <ul class="feedback-list">
                    <?php foreach ($sent_feedbacks as $fb): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($fb['module_nom']); ?></strong>
                            <span>(du <?php echo date('d/m/Y', strtotime($fb['date_session'])); ?>)</span>
                            <div class="feedback-summary">
                                Notes: 
                                Clarté: <?php echo $fb['note_clarte']; ?>/5 | 
                                Rythme: <?php echo $fb['note_rythme']; ?>/5 | 
                                Formateur: <?php echo $fb['note_qualite_formateur']; ?>/5 | 
                                Support: <?php echo $fb['note_support']; ?>/5
                            </div>
                            <?php if (!empty($fb['commentaire'])): ?>
                                <p class="feedback-comment">
                                    <?php echo htmlspecialchars(nl2br($fb['commentaire'])); ?>
                                </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="dashboard-section">
            <h3>Mes informations</h3>
            <p>Mettez à jour vos informations personnelles.</p>
            <a href="index.php?action=show_profile" class="btn-secondary">Modifier mon profil</a>
        </div>

    </div>

    <a href="index.php?action=logout" class="btn-logout">Se déconnecter</a>
</div>