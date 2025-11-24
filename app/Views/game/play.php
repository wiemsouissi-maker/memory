<h1>Memory Game</h1>

<div id="game-info">
    <p>Paires trouvées : <span id="matched-pairs">0</span> / <?= count($cards) / 2 ?></p>
    <p>Nombre de coups : <span id="move-count">0</span></p>
    <p>Temps : <span id="timer">00:00</span></p>
</div>

<div class="game-board">
    <?php foreach ($cards as $card): ?>
        <div class="card" data-id="<?= $card->getId() ?>">
            <div class="card-inner">
                <div class="card-front">
                    <img src="<?= $card->getImagePath() ?>" alt="Image de la carte">
                </div>
                <div class="card-back">
                    <!-- Dos de la carte -->
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card');
        const matchedPairsDisplay = document.getElementById('matched-pairs');
        const moveCountDisplay = document.getElementById('move-count');
        const timerDisplay = document.getElementById('timer');

        let hasFlippedCard = false;
        let lockBoard = false;
        let firstCard, secondCard;
        let matchedPairs = 0;
        let moves = 0;
        let timerInterval;
        let startTime;
        const totalPairs = <?= count($cards) / 2 ?>;

        function startTimer() {
            startTime = Date.now();
            timerInterval = setInterval(() => {
                const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsedTime / 60).toString().padStart(2, '0');
                const seconds = (elapsedTime % 60).toString().padStart(2, '0');
                timerDisplay.textContent = `${minutes}:${seconds}`;
            }, 1000);
        }

        startTimer();

        function flipCard() {
            if (lockBoard) return;
            if (this === firstCard) return;

            this.classList.add('is-flipped');

            if (!hasFlippedCard) {
                // Premier clic
                hasFlippedCard = true;
                firstCard = this;
                return;
            }

            // Deuxième clic
            secondCard = this;
            incrementMoves();
            checkForMatch();
        }

        function incrementMoves() {
            moves++;
            moveCountDisplay.textContent = moves;
        }

        function checkForMatch() {
            // On compare les URLs des images
            let isMatch = firstCard.querySelector('.card-front img').src ===
                secondCard.querySelector('.card-front img').src;

            isMatch ? disableCards() : unflipCards();
        }

        function disableCards() {
            firstCard.removeEventListener('click', flipCard);
            secondCard.removeEventListener('click', flipCard);

            matchedPairs++;
            matchedPairsDisplay.textContent = matchedPairs;

            resetBoard();

            if (matchedPairs === totalPairs) {
                clearInterval(timerInterval);
                const finalTime = timerDisplay.textContent;
                setTimeout(() => {
                    alert(`Bravo ! Vous avez gagné en ${moves} coups et ${finalTime}.`);
                    saveScore(moves);
                }, 500);
            }
        }

        function unflipCards() {
            lockBoard = true;

            setTimeout(() => {
                firstCard.classList.remove('is-flipped');
                secondCard.classList.remove('is-flipped');

                resetBoard();
            }, 1000);
        }

        function resetBoard() {
            [hasFlippedCard, lockBoard] = [false, false];
            [firstCard, secondCard] = [null, null];
        }

        function saveScore(moves) {
            fetch('<?= $baseUrl ?>/game/save-score', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        coups: moves
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (confirm('Score enregistré ! Voir le classement ?')) {
                            window.location.href = '<?= $baseUrl ?>/leaderboard';
                        }
                    } else {
                        if (data.message === 'Non connecté') {
                            if (confirm('Connectez-vous pour sauvegarder votre score. Aller à la connexion ?')) {
                                window.location.href = '<?= $baseUrl ?>/login';
                            }
                        } else {
                            alert('Erreur lors de la sauvegarde du score : ' + data.message);
                        }
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        cards.forEach(card => card.addEventListener('click', flipCard));
    });
</script>