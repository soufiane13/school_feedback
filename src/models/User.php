<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Trouve un utilisateur par email et par rôle (table)
     */
    public function findByEmailAndRole($email, $role) {
        // Détermine la table en fonction du rôle pour la sécurité
        $table = $this->getTableNameFromRole($role);
        if (!$table) {
            return false;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE email = ?");
        $stmt->execute([$email]);
        
        return $stmt->fetch();
    }

    /**
     *  fonction sécurisée pour mapper un rôle à un nom de table
     */
    private function getTableNameFromRole($role) {
        switch ($role) {
            case 'student':
                return 'Etudiants';
            case 'trainer':
                return 'Formateurs';
            case 'admin':
                return 'Admin';
            default:
                return null;
        }
    }
}