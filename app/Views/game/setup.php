<h1>Configurer votre partie de Memory</h1>

<form action="<?= $baseUrl ?>/game/start" method="post">
    <label for="pair_count">Choisissez le nombre de paires (entre 3 et 12) :</label>
    <input type="number" id="pair_count" name="pair_count" min="3" max="12" value="6" required>
    <button type="submit">Commencer à jouer</button>
</form>