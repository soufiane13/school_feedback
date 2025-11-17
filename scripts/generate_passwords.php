<?php
// scripts/generate_passwords.php

/*
 * Ce script est à usage unique.
 * Il se connecte à la BDD, lit les étudiants sans mot de passe,
 * leur en génère un, et l'enregistre (hashé en BDD, clair dans un log).
 */

echo "--- Démarrage du script de génération de mots de passe ---\n";

// Connexion à la base de données (PDO)
$host = '127.0.0.1';
$db_name = 'school_feedback';
$username = 'root';
$password = ''; 
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    echo "Erreur de connexion BDD: " . $e->getMessage() . "\n";
    exit;
}

echo "Connecté à la base de données '$db_name'.\n";

function generatePassword($length = 12) {
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $special = '!@#$%^&*()-_=+[]{}|;:,.<>?';

    $password = '';
    $password .= $lower[random_int(0, strlen($lower) - 1)];
    $password .= $upper[random_int(0, strlen($upper) - 1)];
    $password .= $numbers[random_int(0, strlen($numbers) - 1)];
    $password .= $special[random_int(0, strlen($special) - 1)];

    $all_chars = $lower . $upper . $numbers . $special;
    for ($i = 4; $i < $length; $i++) {
        $password .= $all_chars[random_int(0, strlen($all_chars) - 1)];
    }
    return str_shuffle($password);
}

$logFile = __DIR__ . '/../logins.txt'; 
file_put_contents($logFile, "--- LOGS DES IDENTIFIANTS ETUDIANTS ---\n\n");
echo "Fichier de log créé : $logFile\n";

//Traitement des étudiants
$count = 0;
try {

    $stmt = $pdo->query("SELECT id, email FROM Etudiants WHERE mot_de_passe IS NULL");
    
    while ($student = $stmt->fetch()) {
        $studentId = $student['id'];
        $studentEmail = $student['email'];

        // Générer mdp + hash
        $clearPassword = generatePassword(12);
        $hashedPassword = password_hash($clearPassword, PASSWORD_BCRYPT); 

        $updateStmt = $pdo->prepare(
            "UPDATE Etudiants 
             SET mot_de_passe = ?, premiere_connexion = 1 
             WHERE id = ?"
        );
        $updateStmt->execute([$hashedPassword, $studentId]);

        $logLine = $studentEmail . " : " . $clearPassword . "\n";
        file_put_contents($logFile, $logLine, FILE_APPEND);
        
        $count++;
    }

} catch (\PDOException $e) {
    echo "Erreur lors du traitement des étudiants: " . $e->getMessage() . "\n";
    exit;
}

echo "\n--- TERMINÉ ---\n";
echo "$count mots de passe ont été générés et enregistrés.\n";
echo "Vérifiez le fichier 'logins.txt' pour voir les mots de passe en clair.\n";