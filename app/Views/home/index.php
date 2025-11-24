<?php

/**
 * Vue : Page d'accueil
 * ---------------------
 * Cette vue reçoit une variable $title optionnelle
 * transmise par le HomeController.
 */
?>
<div class="text-center">
  <h1>Bienvenue sur Memory</h1>
  <p>Le jeu classique revisité.</p>

  <div class="flex-center">
    <div class="panel">
      <h2>Memory</h2>
      <p>Exercez votre mémoire en retrouvant toutes les paires de cartes.</p>
      <a href="<?= $baseUrl ?>/game" class="btn">Jouer au Memory</a>
    </div>
  </div>
</div>