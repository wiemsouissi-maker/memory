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
        // Calcul du Base URL pour les images locales
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        $baseUrl = str_replace('\\', '/', $baseUrl);
        $baseUrl = rtrim($baseUrl, '/');

        // Récupération des images locales
        $directory = __DIR__ . '/../../public/assets/images';
        $localImages = [];

        if (is_dir($directory)) {
            $files = scandir($directory);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                // On exclut l'image de fond et le dos de carte
                if ($file === 'background.jpg') continue;
                if ($file === 'card-back.jpg') continue;
                if ($file === 'card-back.png') continue;

                if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
                    $localImages[] = $baseUrl . '/assets/images/' . rawurlencode($file);
                }
            }
        }

        // Détermination du nombre max de paires possibles
        $maxPairs = count($localImages);

        $pairCount = (int)($_POST['pair_count'] ?? 6);

        // Si on a des images locales, on adapte la limite max
        $limitMax = $maxPairs > 0 ? $maxPairs : 12;

        if ($pairCount < 3) $pairCount = 3;
        if ($pairCount > $limitMax) $pairCount = $limitMax;

        // Stocker le nombre de paires en session
        $_SESSION['pair_count'] = $pairCount;

        $selectedImages = [];

        if ($maxPairs >= $pairCount) {
            // Utilisation des images locales
            shuffle($localImages);
            $selectedImages = array_slice($localImages, 0, $pairCount);
        } else {
            // Fallback sur Picsum si pas assez d'images locales
            $imageIds = [10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 28, 29, 30, 31, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49];
            shuffle($imageIds);
            for ($i = 0; $i < $pairCount; $i++) {
                $id = $imageIds[$i];
                $selectedImages[] = "https://picsum.photos/id/$id/200/200";
            }
        }

        $cards = [];
        $cardId = 0;
        foreach ($selectedImages as $imagePath) {
            $value = $imagePath;
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
