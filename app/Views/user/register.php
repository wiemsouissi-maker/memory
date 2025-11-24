<h1>Inscription</h1>

<?php if (isset($error)): ?>
    <div style="color: var(--accent-color); margin-bottom: 1rem; text-align: center; font-weight: bold;"><?= $error ?></div>
<?php endif; ?>

<form action="<?= $baseUrl ?>/register" method="post">
    <label for="login">Login :</label>
    <input type="text" id="login" name="login" required>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">S'inscrire</button>
</form>

<p class="text-center" style="margin-top: 1rem;">
    Déjà un compte ? <a href="<?= $baseUrl ?>/login">Se connecter</a>
</p>