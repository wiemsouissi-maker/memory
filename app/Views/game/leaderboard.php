<h1>Classement des Meilleurs Joueurs</h1>

<div class="panel" style="max-width: 800px; margin: 0 auto;">
    <table>
        <thead>
            <tr>
                <th>Rang</th>
                <th>Joueur</th>
                <th>Paires</th>
                <th>Coups</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($scores)): ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 2rem;">Aucun score enregistré pour le moment. Soyez le premier !</td>
                </tr>
            <?php else: ?>
                <?php foreach ($scores as $index => $score): ?>
                    <tr>
                        <td>#<?= $index + 1 ?></td>
                        <td style="font-weight: bold;"><?= htmlspecialchars($score['login']) ?></td>
                        <td><?= $score['nb_paires'] ?></td>
                        <td><?= $score['coups'] ?></td>
                        <td><?= date('d/m/Y', strtotime($score['date_partie'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>