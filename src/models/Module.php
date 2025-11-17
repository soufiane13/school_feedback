<?php

class Module {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les sessions terminées pour un formateur,
     * pour lesquelles il N'A PAS ENCORE donné de feedback.
     */
    public function getPendingSessionsForTrainer($trainer_id) {
        $sql = "SELECT s.id, m.nom, s.date_session
                FROM Modules m
                JOIN Sessions_Module s ON m.id = s.id_module
                WHERE m.id_formateur = ?
                AND s.date_session < CURDATE()
                AND s.id NOT IN (
                    SELECT id_session_module FROM Feedbacks_Formateurs WHERE id_formateur = ?
                )
                ORDER BY s.date_session DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$trainer_id, $trainer_id]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère l'historique des feedbacks envoyés par un formateur
     */
    public function getSentFeedbackByTrainer($trainer_id) {
        $sql = "SELECT f.*, m.nom AS module_nom, s.date_session
                FROM Feedbacks_Formateurs f
                JOIN Sessions_Module s ON f.id_session_module = s.id
                JOIN Modules m ON s.id_module = m.id
                WHERE f.id_formateur = ?
                ORDER BY f.date_soumission DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$trainer_id]);
        return $stmt->fetchAll();
    }
}