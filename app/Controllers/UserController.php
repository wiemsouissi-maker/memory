<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ScoreModel;
use Core\BaseController;

class UserController extends BaseController
{
    public function register()
    {
        $this->render('user/register', ['title' => 'Inscription']);
    }

    public function registerPost()
    {
        $login = $_POST['login'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($login && $email && $password) {
            $userModel = new UserModel();
            if ($userModel->create($login, $password, $email)) {
                // Connexion automatique après inscription
                $user = $userModel->findByLogin($login);
                $_SESSION['user'] = $user;
                $this->redirect('/');
            } else {
                $this->render('user/register', ['error' => 'Erreur lors de l\'inscription', 'title' => 'Inscription']);
            }
        } else {
            $this->render('user/register', ['error' => 'Tous les champs sont requis', 'title' => 'Inscription']);
        }
    }

    public function login()
    {
        $this->render('user/login', ['title' => 'Connexion']);
    }

    public function loginPost()
    {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new UserModel();
        $user = $userModel->findByLogin($login);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $this->redirect('/');
        } else {
            $this->render('user/login', ['error' => 'Identifiants incorrects', 'title' => 'Connexion']);
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/');
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }

        $scoreModel = new ScoreModel();
        $scores = $scoreModel->getUserScores($_SESSION['user']['id']);
        $bestScore = $scoreModel->getUserBestScore($_SESSION['user']['id']);

        $this->render('user/profile', [
            'title' => 'Mon Profil',
            'user' => $_SESSION['user'],
            'scores' => $scores,
            'bestScore' => $bestScore
        ]);
    }
}
