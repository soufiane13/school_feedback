<?php

class Admin {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les classes pour le filtre
     */
    public function getAllClasses() {
        return $this->pdo->query("SELECT * FROM Classe ORDER BY nom")->fetchAll();
    }

    /**
     * Récupère tous les modules pour le filtre
     */
    public function getAllModules() {
        return $this->pdo->query("SELECT * FROM Modules ORDER BY nom")->fetchAll();
    }

    /**
     * Récupère tous les étudiants pour le filtre
     */
    public function getAllStudents() {
        return $this->pdo->query("SELECT id, nom, prenom FROM Etudiants ORDER BY nom")->fetchAll();
    }
}