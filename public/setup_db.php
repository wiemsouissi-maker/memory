<?php
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

use Core\Database;

try {
    $pdo = Database::getPdo();

    echo "<h1>Installation de la Base de Données</h1>";

    // Table joueurs
    $sqlJoueurs = "CREATE TABLE IF NOT EXISTS joueurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sqlJoueurs);
    echo "✅ Table 'joueurs' vérifiée/créée.<br>";

    // Table scores
    $sqlScores = "CREATE TABLE IF NOT EXISTS scores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        joueur_id INT NOT NULL,
        coups INT NOT NULL,
        nb_paires INT NOT NULL,
        date_partie DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (joueur_id) REFERENCES joueurs(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sqlScores);
    echo "✅ Table 'scores' vérifiée/créée.<br>";

    echo "<br><strong>Installation terminée avec succès !</strong><br>";
    echo "<a href='/'>Retour à l'accueil</a>";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
