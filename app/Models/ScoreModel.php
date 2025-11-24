<?php

namespace App\Models;

use Core\Database;
use PDO;

class ScoreModel
{
    public function create(int $joueurId, int $coups, int $nbPaires): bool
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("INSERT INTO scores (joueur_id, coups, nb_paires, date_partie) VALUES (:joueur_id, :coups, :nb_paires, NOW())");
        return $stmt->execute([
            'joueur_id' => $joueurId,
            'coups' => $coups,
            'nb_paires' => $nbPaires
        ]);
    }

    public function getTopScores(int $limit = 10): array
    {
        $pdo = Database::getPdo();
        // Classement par nombre de paires décroissant (difficulté) puis par nombre de coups croissant (efficacité)
        $stmt = $pdo->prepare("
            SELECT s.*, j.login 
            FROM scores s 
            JOIN joueurs j ON s.joueur_id = j.id 
            ORDER BY s.nb_paires DESC, s.coups ASC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserScores(int $joueurId): array
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("
            SELECT * FROM scores 
            WHERE joueur_id = :joueur_id 
            ORDER BY date_partie DESC
        ");
        $stmt->execute(['joueur_id' => $joueurId]);
        return $stmt->fetchAll();
    }

    public function getUserBestScore(int $joueurId): ?array
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("
            SELECT * FROM scores 
            WHERE joueur_id = :joueur_id 
            ORDER BY nb_paires DESC, coups ASC 
            LIMIT 1
        ");
        $stmt->execute(['joueur_id' => $joueurId]);
        $score = $stmt->fetch();
        return $score ?: null;
    }
}
