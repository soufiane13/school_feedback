<?php 
// src/views/pages/trainer_feedback_form.php 
?>

<div class="dashboard-card">
    <h2>Feedback sur la classe</h2>
    <p>Évaluez la classe pour le module : <strong><?php echo htmlspecialchars($module['nom']); ?></strong></p>

    <form id="trainerFeedbackForm" action="index.php?action=submit_trainer_feedback" method="POST">
        
        <input type="hidden" name="id_session_module" value="<?php echo $session_id; ?>">

        <div class="form-group">
            <label>Qualité du travail global de la classe *</label>
            <div class="star-rating" data-name="note_travail_global">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="note_travail_global" class="star-value-input" value="" required>
        </div>
        
        <div class="form-group">
            <label>Niveau de participation *</label>
            <div class="star-rating" data-name="note_participation">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="note_participation" class="star-value-input" value="" required>
        </div>

        <div class="form-group">
            <label for="commentaire">Commentaire libre</label>
            <textarea id="commentaire" name="commentaire" rows="4" placeholder="Remarques sur la ponctualité, l'engagement, etc."></textarea>
        </div>
        
        <button type="submit" class="btn-primary">Envoyer mon feedback</button>
        <a href="index.php?action=trainer_dashboard" class="back-link" style="margin-top: 16px; display: block;">Annuler</a>

    </form>
</div>