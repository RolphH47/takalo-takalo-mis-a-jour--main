-- ========================================
-- DONNÉES DE TEST
-- ========================================

-- Admin par défaut (password: admin123)
INSERT INTO `users` (`email`, `password`, `nom`, `prenom`, `role`) VALUES
('admin@takalo.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Super', 'admin');
INSERT INTO `users` (`email`, `password`, `nom`, `prenom`, `role`) VALUES
('fenosoa@gmail.com', '$2y$10$sWtW0fCPIagMIJsfZ0xMPugecXt6zm8tRr6rpdTnDdRqf3WTblMUm', 'fenosoa', 'Super', 'admin');

-- Utilisateurs de test (password: password123)
INSERT INTO `users` (`email`, `password`, `nom`, `prenom`, `telephone`, `adresse`) VALUES
('rakoto@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rakoto', 'Jean', '0340000001', 'Antananarivo, Madagascar'),
('rabe@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rabe', 'Marie', '0340000002', 'Fianarantsoa, Madagascar'),
('rasoa@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rasoa', 'Sophie', '0340000003', 'Toamasina, Madagascar');

-- Catégories
INSERT INTO `categories` (`nom`, `description`, `icone`) VALUES
('Vêtements', 'Vêtements, chaussures et accessoires de mode', 'bi-bag'),
('Livres', 'Livres, magazines et bandes dessinées', 'bi-book'),
('DVD/Films', 'Films, séries et documentaires en DVD ou Blu-ray', 'bi-disc'),
('Électronique', 'Appareils électroniques et accessoires', 'bi-laptop'),
('Jouets', 'Jouets et jeux pour enfants', 'bi-puzzle'),
('Sports', 'Équipements et accessoires de sport', 'bi-trophy'),
('Maison', 'Décoration et équipement pour la maison', 'bi-house'),
('Musique', 'Instruments de musique et CD', 'bi-music-note');

-- Objets de test
INSERT INTO `objets` (`user_id`, `category_id`, `titre`, `description`, `prix_estimatif`, `etat`, `statut`) VALUES
(2, 1, 'Veste en cuir noire', 'Veste en cuir véritable, taille M, très bon état', 50000.00, 'tres_bon', 'disponible'),
(2, 2, 'Collection Harry Potter', 'Les 7 tomes en français, édition originale', 30000.00, 'bon', 'disponible'),
(2, 3, 'DVD Trilogie Le Seigneur des Anneaux', 'Version extended avec bonus', 15000.00, 'tres_bon', 'disponible'),
(3, 4, 'iPhone 11', 'iPhone 11 64Go, noir, bon état général', 200000.00, 'bon', 'disponible'),
(3, 5, 'LEGO Star Wars', 'Set complet, jamais ouvert', 40000.00, 'neuf', 'disponible'),
(3, 6, 'Raquette de tennis Wilson', 'Raquette professionnelle avec housse', 35000.00, 'tres_bon', 'disponible'),
(4, 7, 'Lampe design moderne', 'Lampe de table design scandinave', 25000.00, 'tres_bon', 'disponible'),
(4, 8, 'Guitare acoustique Yamaha', 'Guitare débutant, état parfait', 80000.00, 'tres_bon', 'disponible');

-- Photos des objets (exemples - à adapter avec de vraies photos)
INSERT INTO `photos_objets` (`objet_id`, `chemin`, `est_principale`, `ordre`) VALUES
(1, 'uploads/objets/veste-cuir-1.jpg', TRUE, 1),
(2, 'uploads/objets/harry-potter-1.jpg', TRUE, 1),
(3, 'uploads/objets/lotr-dvd-1.jpg', TRUE, 1),
(4, 'uploads/objets/iphone11-1.jpg', TRUE, 1),
(5, 'uploads/objets/lego-sw-1.jpg', TRUE, 1),
(6, 'uploads/objets/raquette-1.jpg', TRUE, 1),
(7, 'uploads/objets/lampe-1.jpg', TRUE, 1),
(8, 'uploads/objets/guitare-1.jpg', TRUE, 1);

-- Propositions d'échange de test
INSERT INTO `propositions` (`objet_propose_id`, `objet_demande_id`, `user_proposant_id`, `user_destinataire_id`, `message`, `statut`) VALUES
(1, 4, 2, 3, 'Bonjour, je suis intéressé par votre iPhone. Ma veste est en très bon état.', 'en_attente'),
(2, 8, 2, 4, 'Je collectionne les instruments, vos livres m\'intéressent pour ma guitare.', 'en_attente'),
(5, 3, 3, 2, 'Je propose mon LEGO contre vos DVD LOTR.', 'accepte');

-- Échange effectué
INSERT INTO `echanges` (`proposition_id`, `objet1_id`, `objet2_id`, `user1_id`, `user2_id`, `lieu_echange`, `commentaire`) VALUES
(3, 5, 3, 3, 2, 'Analakely, Antananarivo', 'Échange réussi, tout s\'est bien passé !');

-- Historique pour l'échange effectué
INSERT INTO `historique_objets` (`objet_id`, `user_ancien_id`, `user_nouveau_id`, `echange_id`) VALUES
(5, 3, 2, 1),
(3, 2, 3, 1);

-- Mettre à jour le statut des objets échangés
UPDATE `objets` SET `statut` = 'echange' WHERE `id` IN (3, 5);
