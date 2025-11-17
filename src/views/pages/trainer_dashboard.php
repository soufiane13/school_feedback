<?php 
// src/views/pages/trainer_dashboard.php 
?>

<div class="dashboard-card">

    <?php if (isset($_GET['feedback']) && $_GET['feedback'] === 'success'): ?>
        <div class="success-message">
            Votre feedback sur la classe a été enregistré. Merci !
        </div>
    <?php endif; ?>

    <h2>Tableau de Bord Enseignant</h2>
    
    <p>Bienvenue, <strong><?php echo htmlspecialchars($trainerEmail); ?></strong> !</p>
    
    <div class="dashboard-sections">
        
        <div class="dashboard-section">
            <h3>Feedbacks sur les classes (à donner)</h3>
            
            <?php if (empty($pending_sessions)): ?>
                <p>Vous n'avez aucune session terminée en attente de feedback.</p>
            <?php else: ?>
                <ul class="feedback-list">
                    <?php foreach ($pending_sessions as $session): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($session['nom']); ?></strong>
                            <span>(du <?php echo date('d/m/Y', strtotime($session['date_session'])); ?>)</span>
                            <br>
                            <a href="index.php?action=show_trainer_feedback&session_id=<?php echo $session['id']; ?>" class="btn-primary" style="margin-top: 10px;">
                                Donner mon feedback
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="dashboard-section">
            <h3>Historique de mes feedbacks</h3>
            
            <?php if (empty($sent_feedbacks)): ?>
                <p>Vous n'avez pas encore envoyé de feedback.</p>
            <?php else: ?>
                <ul class="feedback-list">
                    <?php foreach ($sent_feedbacks as $fb): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($fb['module_nom']); ?></strong>
                            <span>(Session du <?php echo date('d/m/Y', strtotime($fb['date_session'])); ?>)</span>
                            <div class="feedback-summary">
                                Notes: 
                                Participation: <?php echo $fb['note_participation']; ?>/5 | 
                                Travail: <?php echo $fb['note_travail_global']; ?>/5
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

    </div>

    <a href="index.php?action=logout" class="btn-logout">Se déconnecter</a>
</div>