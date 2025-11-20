-- ------------------------------------------------------------
--             Memory Game - Base de données complète
-- ------------------------------------------------------------

-- 1️⃣ Création de la base
CREATE DATABASE IF NOT EXISTS memory
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE memory;

-- ------------------------------------------------------------
-- 2️⃣ Table USERS (profils joueurs)
-- ------------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- INSERT exemples utilisateurs
INSERT INTO users (username, email, password) VALUES
('alice', 'alice@mail.com', 'password_hash_1'),
('bob', 'bob@mail.com', 'password_hash_2'),
('charlie', 'charlie@mail.com', 'password_hash_3');

-- ------------------------------------------------------------
-- 3️⃣ Table SCORES (classement)
-- ------------------------------------------------------------
CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pairs INT NOT NULL,
    moves INT NOT NULL,
    duration INT NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- INSERT exemples scores
INSERT INTO scores (user_id, pairs, moves, duration) VALUES
(1, 6, 14, 75),
(2, 6, 20, 90),
(3, 8, 30, 130),
(1, 12, 44, 210);

-- ------------------------------------------------------------
-- 4️⃣ Table GAMES (historique individuel) — optionnel
-- ------------------------------------------------------------
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pairs INT NOT NULL,
    moves INT NOT NULL,
    duration INT NOT NULL,
    status ENUM('completed','abandoned') DEFAULT 'completed',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- INSERT exemples de parties
INSERT INTO games (user_id, pairs, moves, duration, status) VALUES
(1, 6, 14, 75, 'completed'),
(1, 8, 26, 120, 'completed'),
(2, 6, 20, 90, 'completed'),
(3, 12, 60, 240, 'abandoned');

-- ------------------------------------------------------------
-- Base prête pour l'utilisation
-- ------------------------------------------------------------
