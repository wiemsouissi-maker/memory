<?php

namespace App\Models;

use Core\Database;
use PDO;

class UserModel
{
    public function create(string $login, string $password, string $email): bool
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("INSERT INTO joueurs (login, password, email, created_at) VALUES (:login, :password, :email, NOW())");
        return $stmt->execute([
            'login' => $login,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email
        ]);
    }

    public function findByLogin(string $login): ?array
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM joueurs WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM joueurs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
