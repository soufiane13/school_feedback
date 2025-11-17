<?php 
// src/views/pages/admin_dashboard.php 
?>

<div class="admin-container">
    <div class="admin-header">
        <h2>Tableau de Bord Administration</h2>
        <p>Bienvenue, <strong><?php echo htmlspecialchars($adminEmail); ?></strong> !</p>
        <a href="index.php?action=logout" class="btn-logout">Se déconnecter</a>
    </div>

    <div class="admin-filters dashboard-card">
        <h3>Filtrer les résultats</h3>
        
        <form action="index.php" method="GET" class="filter-form">
            <input type="hidden" name="action" value="admin_dashboard">

            <div class="form-group">
                <label for="filter_classe">Filtrer par Classe</label>
                <select id="filter_classe" name="id_classe">
                    <option value="">-- Toutes les classes --</option>
                    <?php foreach ($filter_lists['classes'] as $classe): ?>
                        <option value="<?php echo $classe['id']; ?>" <?php echo (isset($_GET['id_classe']) && $_GET['id_classe'] == $classe['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($classe['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="filter_module">Filtrer par Module</label>
                <select id="filter_module" name="id_module">
                    <option value="">-- Tous les modules --</option>
                    <?php foreach ($filter_lists['modules'] as $module): ?>
                        <option value="<?php echo $module['id']; ?>" <?php echo (isset($_GET['id_module']) && $_GET['id_module'] == $module['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($module['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="filter_etudiant">Filtrer par Étudiant</label>
                <select id="filter_etudiant" name="id_etudiant">
                    <option value="">-- Tous les étudiants --</option>
                    <?php foreach ($filter_lists['students'] as $student): ?>
                        <option value="<?php echo $student['id']; ?>" <?php echo (isset($_GET['id_etudiant']) && $_GET['id_etudiant'] == $student['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($student['prenom'] . ' ' . $student['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn-primary">Filtrer</button>
            <a href="index.php?action=admin_dashboard" class="btn-secondary">Réinitialiser</a>
        </form>
    </div>

    <div class="admin-table-container dashboard-card">
        <h3>Tous les Feedbacks Étudiants</h3>
        
        <?php if (empty($all_feedbacks)): ?>
            <p>Aucun feedback étudiant n'a été trouvé dans la base de données.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Étudiant</th>
                        <th>Classe</th>
                        <th>Module</th>
                        <th>Notes (Clarté/Rythme/Formateur/Support)</th>
                        <th>Commentaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_feedbacks as $fb): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($fb['date_soumission'])); ?></td>
                            <td><?php echo htmlspecialchars($fb['etudiant_prenom'] . ' ' . $fb['etudiant_nom']); ?></td>
                            <td><?php echo htmlspecialchars($fb['classe_nom']); ?></td>
                            <td><?php echo htmlspecialchars($fb['module_nom']); ?></td>
                            <td>
                                <?php echo $fb['note_clarte']; ?>/5 | 
                                <?php echo $fb['note_rythme']; ?>/5 | 
                                <?php echo $fb['note_qualite_formateur']; ?>/5 | 
                                <?php echo $fb['note_support']; ?>/5
                            </td>
                            <td class="comment-cell">
                                <?php echo htmlspecialchars(nl2br($fb['commentaire'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>