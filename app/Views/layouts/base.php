<?php

/**
 * Layout principal
 * -----------------
 * Ce fichier définit la structure HTML commune à toutes les pages.
 * Il inclut dynamiquement le contenu spécifique à chaque vue via la variable $content.
 */
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">

  <!-- Titre de la page (sécurisé avec htmlspecialchars, valeur par défaut si non défini) -->
  <title><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Mini MVC' ?></title>

  <!-- Bonne pratique : rendre le site responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= $baseUrl ?>/assets/global.css?v=<?= time() ?>">
  <!-- (Optionnel) Ajout d’un peu de style basique -->

</head>

<body>
  <!-- Menu de navigation global -->
  <nav>
    <a href="<?= $baseUrl ?>/">Accueil</a>
    <a href="<?= $baseUrl ?>/game">Memory</a>
    <a href="<?= $baseUrl ?>/leaderboard">Classement</a>

    <?php if (isset($_SESSION['user'])): ?>
      <a href="<?= $baseUrl ?>/profile">Mon Profil (<?= htmlspecialchars($_SESSION['user']['login']) ?>)</a>
      <a href="<?= $baseUrl ?>/logout">Déconnexion</a>
    <?php else: ?>
      <a href="<?= $baseUrl ?>/login">Connexion</a>
      <a href="<?= $baseUrl ?>/register">Inscription</a>
    <?php endif; ?>
  </nav>

  <!-- Contenu principal injecté depuis BaseController -->
  <main>
    <?= $content ?>
  </main>
</body>

</html>