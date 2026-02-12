-- ========================================
-- Base de données Takalo-Takalo
-- Plateforme d'échange d'objets
-- ========================================

CREATE DATABASE IF NOT EXISTS `takalo_takalo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `takalo_takalo`;

-- ========================================
-- Table: users
-- ========================================
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password` VARCHAR(191) NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100),
  `telephone` VARCHAR(20),
  `adresse` TEXT,
  `role` ENUM('user', 'admin') DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_email` (`email`),
  INDEX `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: categories
-- ========================================
CREATE TABLE `categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `icone` VARCHAR(50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: objets
-- ========================================
CREATE TABLE `objets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `titre` VARCHAR(191) NOT NULL,
  `description` TEXT NOT NULL,
  `prix_estimatif` DECIMAL(10, 2),
  `etat` ENUM('neuf', 'tres_bon', 'bon', 'acceptable', 'usage') DEFAULT 'bon',
  `statut` ENUM('disponible', 'en_echange', 'echange', 'retire') DEFAULT 'disponible',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_category_id` (`category_id`),
  INDEX `idx_statut` (`statut`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: photos_objets
-- ========================================
CREATE TABLE `photos_objets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `objet_id` INT UNSIGNED NOT NULL,
  `chemin` VARCHAR(500) NOT NULL,
  `est_principale` BOOLEAN DEFAULT FALSE,
  `ordre` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`objet_id`) REFERENCES `objets`(`id`) ON DELETE CASCADE,
  INDEX `idx_objet_id` (`objet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: propositions
-- ========================================
CREATE TABLE `propositions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `objet_propose_id` INT UNSIGNED NOT NULL COMMENT 'L\'objet que je propose',
  `objet_demande_id` INT UNSIGNED NOT NULL COMMENT 'L\'objet que je veux',
  `user_proposant_id` INT UNSIGNED NOT NULL COMMENT 'L\'utilisateur qui propose l\'échange',
  `user_destinataire_id` INT UNSIGNED NOT NULL COMMENT 'Le propriétaire de l\'objet demandé',
  `message` TEXT,
  `statut` ENUM('en_attente', 'accepte', 'refuse', 'annule') DEFAULT 'en_attente',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`objet_propose_id`) REFERENCES `objets`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`objet_demande_id`) REFERENCES `objets`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_proposant_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_destinataire_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_objet_propose` (`objet_propose_id`),
  INDEX `idx_objet_demande` (`objet_demande_id`),
  INDEX `idx_user_proposant` (`user_proposant_id`),
  INDEX `idx_user_destinataire` (`user_destinataire_id`),
  INDEX `idx_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: echanges
-- ========================================
CREATE TABLE `echanges` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `proposition_id` INT UNSIGNED NOT NULL,
  `objet1_id` INT UNSIGNED NOT NULL,
  `objet2_id` INT UNSIGNED NOT NULL,
  `user1_id` INT UNSIGNED NOT NULL,
  `user2_id` INT UNSIGNED NOT NULL,
  `date_echange` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `lieu_echange` VARCHAR(191),
  `commentaire` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`proposition_id`) REFERENCES `propositions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`objet1_id`) REFERENCES `objets`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`objet2_id`) REFERENCES `objets`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`user1_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`user2_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  INDEX `idx_proposition` (`proposition_id`),
  INDEX `idx_user1` (`user1_id`),
  INDEX `idx_user2` (`user2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: historique_objets
-- ========================================
CREATE TABLE `historique_objets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `objet_id` INT UNSIGNED NOT NULL,
  `user_ancien_id` INT UNSIGNED,
  `user_nouveau_id` INT UNSIGNED NOT NULL,
  `echange_id` INT UNSIGNED,
  `date_changement` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`objet_id`) REFERENCES `objets`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_ancien_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`user_nouveau_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`echange_id`) REFERENCES `echanges`(`id`) ON DELETE SET NULL,
  INDEX `idx_objet` (`objet_id`),
  INDEX `idx_date` (`date_changement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
