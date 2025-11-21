<?php

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

// Importation des classes avec namespaces pour éviter les conflits de noms
use Core\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . ":/..");
$dotenv->safeLoad();

// Initialisation du routeur
$router = new Router();

// Définition des routes de l'application
// La route "/" pointe vers la méthode "index" du contrôleur HomeController
$router->get('/', 'App\\Controllers\\HomeController@index');
// La route "/game" pointe vers la méthode "index" du contrôleur GameController
$router->get('/game', 'App\\Controllers\\GameController@index');

// Exécution du routeur :
// On analyse l'URI et la méthode HTTP pour appeler le contrôleur et la méthode correspondants
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
