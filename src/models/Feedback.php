<?php

class Feedback {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les sessions de module ouvertes pour un étudiant
     */
    public function getPendingModules($student_id) {
        
        $sql = "SELECT s.id, m.nom 
                FROM Inscriptions i
                JOIN Sessions_Module s ON i.id_session_module = s.id
                JOIN Modules m ON s.id_module = m.id
                WHERE i.id_etudiant = ?
                AND s.date_session = CURDATE()
                AND s.id NOT IN (
                    SELECT id_session_module FROM Feedbacks_Etudiants WHERE id_etudiant = ?
                )";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $student_id]);
        return $stmt->fetchAll();
    }

    /**
     * Sauvegarde un nouveau feedback en BDD
     */
    public function save($data, $student_id) {

        try {
            $sql = "INSERT INTO Feedbacks_Etudiants 
                        (id_etudiant, id_session_module, note_clarte, note_rythme, note_qualite_formateur, note_support, commentaire)
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                $student_id,
                $data['id_session_module'],
                $data['note_clarte'],
                $data['note_rythme'],
                $data['note_qualite_formateur'],
                $data['note_support'],
                $data['commentaire']
            ]);
            
            return true; 

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                throw new Exception("Vous avez déjà soumis un feedback pour ce module.");
            } else {
                throw $e; 
            }
        }
    }

    /**
     * Récupère l'historique des feedbacks envoyés par un étudiant
     */
    public function getSentFeedback($student_id) {

        $sql = "SELECT f.*, m.nom AS module_nom, s.date_session
                FROM Feedbacks_Etudiants f
                JOIN Sessions_Module s ON f.id_session_module = s.id
                JOIN Modules m ON s.id_module = m.id
                WHERE f.id_etudiant = ?
                ORDER BY f.date_soumission DESC"; 
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }


    /**
     * Sauvegarde un nouveau feedback (côté formateur) en BDD
     */
    public function saveTrainerFeedback($data, $trainer_id) {
        try {
            $sql = "INSERT INTO Feedbacks_Formateurs
                        (id_formateur, id_session_module, note_participation, note_travail_global, commentaire)
                    VALUES
                        (?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                $trainer_id,
                $data['id_session_module'],
                $data['note_participation'],
                $data['note_travail_global'],
                $data['commentaire']
            ]);
            
            return true; 

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                throw new Exception("Vous avez déjà soumis un feedback pour cette session de module.");
            } else {
                throw $e;
            }
        }
    }

/**
     * Récupère TOUS les feedbacks (pour l'admin) AVEC FILTRES
     */
    public function getAllFeedbacks($filters = []) {
        $sql = "SELECT 
                    f.*, 
                    m.nom AS module_nom, 
                    c.nom AS classe_nom,
                    e.nom AS etudiant_nom,
                    e.prenom AS etudiant_prenom
                FROM Feedbacks_Etudiants f
                JOIN Etudiants e ON f.id_etudiant = e.id
                JOIN Classe c ON e.id_classe = c.id
                JOIN Sessions_Module s ON f.id_session_module = s.id
                JOIN Modules m ON s.id_module = m.id";
        
        $where_clauses = [];
        $parameters = [];

        // Construire les filtres dynamiquement
        if (!empty($filters['id_classe'])) {
            $where_clauses[] = "c.id = ?";
            $parameters[] = $filters['id_classe'];
        }
        if (!empty($filters['id_module'])) {
            $where_clauses[] = "m.id = ?";
            $parameters[] = $filters['id_module'];
        }
        if (!empty($filters['id_etudiant'])) {
            $where_clauses[] = "e.id = ?";
            $parameters[] = $filters['id_etudiant'];
        }

        // Ajouter les clauses WHERE à la requête SQL
        if (count($where_clauses) > 0) {
            $sql .= " WHERE " . implode(' AND ', $where_clauses);
        }
        
        $sql .= " ORDER BY f.date_soumission DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);
        return $stmt->fetchAll();
    }
}