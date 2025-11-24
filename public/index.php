<?php

// Démarrage de la session pour gérer la connexion utilisateur
session_start();

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

// Importation des classes avec namespaces pour éviter les conflits de noms
use Core\Router;

// Initialisation du routeur
$router = new Router();

// Définition des routes de l'application
// La route "/" pointe vers la méthode "index" du contrôleur HomeController
$router->get('/', 'App\\Controllers\\HomeController@index');
// Routes pour le jeu Memory
$router->get('/game', 'App\\Controllers\\GameController@index');
$router->post('/game/start', 'App\\Controllers\\GameController@start');
$router->post('/game/save-score', 'App\\Controllers\\GameController@saveScore');
$router->get('/leaderboard', 'App\\Controllers\\GameController@leaderboard');

// Routes Utilisateur
$router->get('/login', 'App\\Controllers\\UserController@login');
$router->post('/login', 'App\\Controllers\\UserController@loginPost');
$router->get('/register', 'App\\Controllers\\UserController@register');
$router->post('/register', 'App\\Controllers\\UserController@registerPost');
$router->get('/logout', 'App\\Controllers\\UserController@logout');
$router->get('/profile', 'App\\Controllers\\UserController@profile');

// Exécution du routeur :
// On analyse l'URI et la méthode HTTP pour appeler le contrôleur et la méthode correspondants
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
