<?php

namespace App\Models;

/**
 * Classe Card
 * ---------------------
 * Représente une seule carte du jeu Memory.
 * Elle est utilisée par le MemoryGameModel.
 */
class Card
{

    private int $id;        // Identifiant unique de cette instance de carte
    private string $value;  // La "valeur" ou "symbole" qui détermine la paire
    private bool $is_flipped = false; // true si la carte est retournée/visible
    private bool $is_matched = false; // true si la paire de cette carte a été trouvée

    /**
     * Constructeur
     * @param string $value La valeur de la carte (pour la paire)
     * @param int $id L'identifiant unique de la carte
     */
    public function __construct(string $value, int $id)
    {
        $this->id = $id;
        $this->value = $value;
    }

    // --- Méthodes (Getters) ---

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isFlipped(): bool
    {
        return $this->is_flipped;
    }

    public function isMatched(): bool
    {
        return $this->is_matched;
    }

    // --- Méthodes (Setters/Actions) ---

    /**
     * Retourne la carte (change l'état à visible)
     */
    public function flip(): void
    {
        if (!$this->is_matched) {
            $this->is_flipped = true;
        }
    }

    /**
     * Cache la carte (change l'état à caché)
     */
    public function unflip(): void
    {
        if (!$this->is_matched) {
            $this->is_flipped = false;
        }
    }

    /**
     * Marque la carte comme faisant partie d'une paire trouvée
     */
    public function setMatched(): void
    {
        $this->is_matched = true;
        $this->is_flipped = true; // Une carte trouvée reste visible
    }
}
