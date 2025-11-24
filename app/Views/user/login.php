<h1>Connexion</h1>

<?php if (isset($error)): ?>
    <div style="color: var(--accent-color); margin-bottom: 1rem; text-align: center; font-weight: bold;"><?= $error ?></div>
<?php endif; ?>

<form action="<?= $baseUrl ?>/login" method="post">
    <label for="login">Login :</label>
    <input type="text" id="login" name="login" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

<p class="text-center" style="margin-top: 1rem;">
    Pas encore de compte ? <a href="<?= $baseUrl ?>/register">S'inscrire</a>
</p>