<?php 
// src/views/pages/feedback_form.php 
// La variable $available_modules est disponible
?>

<div class="dashboard-card">
    <h2>Formulaire de Feedback</h2>
    <p>Évaluez le module que vous venez de terminer.</p>

    <form id="feedbackForm" action="index.php?action=submit_feedback" method="POST">
        
        <div class="form-group">
            <label for="module">Module concerné *</label>
            <select id="module" name="id_session_module" required>
                <option value="">-- Sélectionnez un module --</option>
                <?php foreach ($available_modules as $module): ?>
                    <option value="<?php echo $module['id']; ?>">
                        <?php echo htmlspecialchars($module['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Clarté du formateur *</label>
            <div class="star-rating" data-name="note_clarte">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="note_clarte" class="star-value-input" value="" required>
        </div>
        
        <div class="form-group">
            <label>Rythme de la séance *</label>
            <div class="star-rating" data-name="note_rythme">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="note_rythme" class="star-value-input" value="" required>
        </div>

        <div class="form-group">
            <label>Qualité du formateur *</label>
            <div class="star-rating" data-name="note_qualite_formateur">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="note_qualite_formateur" class="star-value-input" value="" required>
        </div>

        <div class="form-group">
            <label>Qualité du support pédagogique *</label>
            <div class="star-rating" data-name="note_support">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="note_support" class="star-value-input" value="" required>
        </div>

        <div class="form-group">
            <label for="commentaire">Commentaire libre</label>
            <textarea id="commentaire" name="commentaire" rows="4" placeholder="Vos remarques pour nous aider à nous améliorer..."></textarea>
        </div>

        <div id="confirmation-message" class="success-message" style="display: none;">
            Votre feedback a été envoyé avec succès !
        </div>
        
        <button type="submit" class="btn-primary">Envoyer mon feedback</button>
        <a href="index.php?action=student_dashboard" class="back-link" style="margin-top: 16px; display: block;">Retour au tableau de bord</a>

    </form>
</div>