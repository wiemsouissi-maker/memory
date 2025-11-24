<?php

namespace App\Controllers;

use App\Models\Card;
use App\Models\ScoreModel;
use Core\BaseController;

/**
 * Classe GameController
 * ----------------------
 * Contrôleur responsable de la gestion du jeu Memory.
 */
class GameController extends BaseController
{
    /**
     * Affiche la page de configuration de la partie.
     */
    public function index(): void
    {
        $this->render('game/setup', [
            'title' => 'Configurer la partie'
        ]);
    }

    /**
     * Initialise et démarre une nouvelle partie.
     */
    public function start()
    {
        $pairCount = (int)($_POST['pair_count'] ?? 6);
        if ($pairCount < 3 || $pairCount > 12) {
            $pairCount = 6; // Valeur par défaut sécurisée
        }

        // Stocker le nombre de paires en session pour la sauvegarde du score
        $_SESSION['pair_count'] = $pairCount;

        // Sélectionner des images au hasard via Picsum
        $selectedImages = [];

        // Liste d'IDs d'images Picsum valides pour garantir l'affichage
        $imageIds = [
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
            20,
            21,
            22,
            23,
            24,
            25,
            28,
            29,
            30,
            31,
            40,
            41,
            42,
            43,
            44,
            45,
            46,
            47,
            48,
            49
        ];
        shuffle($imageIds); // Mélange pour varier les parties

        for ($i = 0; $i < $pairCount; $i++) {
            // On prend un ID unique pour chaque paire
            $id = $imageIds[$i];
            $selectedImages[] = "https://picsum.photos/id/$id/200/200";
        }

        $cards = [];
        $cardId = 0;
        foreach ($selectedImages as $imagePath) {
            $value = $imagePath; // La valeur est l'URL de l'image
            // Crée deux cartes pour chaque image pour former une paire
            $cards[] = new Card($cardId++, $value, $imagePath);
            $cards[] = new Card($cardId++, $value, $imagePath);
        }

        // Mélanger les cartes
        shuffle($cards);

        // Stocker les cartes en session
        $_SESSION['game_board'] = $cards;
        $_SESSION['start_time'] = time();
        $_SESSION['move_count'] = 0;

        $this->render('game/play', [
            'title' => 'Memory Game',
            'cards' => $cards
        ]);
    }

    public function saveScore()
    {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Non connecté']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $coups = $data['coups'] ?? 0;
        $pairCount = $_SESSION['pair_count'] ?? 6;

        if ($coups > 0) {
            try {
                $scoreModel = new ScoreModel();
                $scoreModel->create($_SESSION['user']['id'], $coups, $pairCount);
                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur BDD : ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Score invalide']);
        }
    }

    public function leaderboard()
    {
        $scoreModel = new ScoreModel();
        $topScores = $scoreModel->getTopScores(10);

        $this->render('game/leaderboard', [
            'title' => 'Classement',
            'scores' => $topScores
        ]);
    }
}
