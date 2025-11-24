<?php

namespace App\Models;

/**
 * Classe Card
 * -----------
 * Représente une carte du jeu Memory.
 */
class Card
{
    private int $id;
    private string $value; // La valeur qui permet de former une paire (ex: URL de l'image)
    private string $imagePath; // Chemin ou URL vers l'image de la carte
    private bool $isFlipped = false; // La carte est-elle retournée ?
    private bool $isMatched = false; // La carte a-t-elle été trouvée ?

    public function __construct(int $id, string $value, string $imagePath)
    {
        $this->id = $id;
        $this->value = $value;
        $this->imagePath = $imagePath;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function isFlipped(): bool
    {
        return $this->isFlipped;
    }

    public function flip(): void
    {
        $this->isFlipped = !$this->isFlipped;
    }

    public function isMatched(): bool
    {
        return $this->isMatched;
    }

    public function setMatched(bool $matched): void
    {
        $this->isMatched = $matched;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'imagePath' => $this->imagePath,
            'isFlipped' => $this->isFlipped,
            'isMatched' => $this->isMatched,
        ];
    }
}
