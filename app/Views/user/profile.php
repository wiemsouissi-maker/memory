<h1>Mon Profil</h1>

<div class="panel" style="max-width: 800px; margin: 0 auto;">
    <h2>Bonjour, <?= htmlspecialchars($user['login']) ?></h2>
    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
    <p>Membre depuis le : <?= htmlspecialchars($user['created_at']) ?></p>

    <h3 style="margin-top: 2rem;">Meilleur Score</h3>
    <?php if ($bestScore): ?>
        <p>
            <?= $bestScore['coups'] ?> coups
            (<?= $bestScore['nb_paires'] ?> paires)
            le <?= date('d/m/Y H:i', strtotime($bestScore['date_partie'])) ?>
        </p>
    <?php else: ?>
        <p>Aucun score enregistré.</p>
    <?php endif; ?>

    <h3 style="margin-top: 2rem;">Historique des parties</h3>
    <?php if (count($scores) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Paires</th>
                    <th>Coups</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $score): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($score['date_partie'])) ?></td>
                        <td><?= $score['nb_paires'] ?></td>
                        <td><?= $score['coups'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune partie jouée.</p>
    <?php endif; ?>
</div>