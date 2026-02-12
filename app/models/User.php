<?php

namespace App\Models;

use PDO;

class User extends Model {
    
    protected $table = 'users';
    
    /**
     * Créer un nouvel utilisateur avec hashage du mot de passe
     */
    public function register($data) {
        // Hasher le mot de passe
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $this->create($data);
    }
    
    /**
     * Authentifier un utilisateur
     */
    public function authenticate($email, $password) {
        $user = $this->findBy('email', $email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Ne pas retourner le mot de passe
            unset($user['password']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists($email) {
        return $this->findBy('email', $email) !== false;
    }
    
    /**
     * Récupérer les objets d'un utilisateur
     */
    public function getObjets($userId, $statut = null) {
        $sql = "SELECT o.*, c.nom as categorie_nom 
                FROM objets o 
                LEFT JOIN categories c ON o.category_id = c.id 
                WHERE o.user_id = ?";
        
        $params = [$userId];
        
        if ($statut) {
            $sql .= " AND o.statut = ?";
            $params[] = $statut;
        }
        
        $sql .= " ORDER BY o.created_at DESC";
        
        return $this->query($sql, $params);
    }
    
    /**
     * Récupérer les propositions reçues par un utilisateur
     */
    public function getPropositionsRecues($userId, $statut = null) {
        $sql = "SELECT p.*, 
                       op.titre as objet_propose_titre,
                       od.titre as objet_demande_titre,
                       u.nom as proposant_nom,
                       u.email as proposant_email
                FROM propositions p
                LEFT JOIN objets op ON p.objet_propose_id = op.id
                LEFT JOIN objets od ON p.objet_demande_id = od.id
                LEFT JOIN users u ON p.user_proposant_id = u.id
                WHERE p.user_destinataire_id = ?";
        
        $params = [$userId];
        
        if ($statut) {
            $sql .= " AND p.statut = ?";
            $params[] = $statut;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        return $this->query($sql, $params);
    }
    
    /**
     * Récupérer les propositions envoyées par un utilisateur
     */
    public function getPropositionsEnvoyees($userId, $statut = null) {
        $sql = "SELECT p.*, 
                       op.titre as objet_propose_titre,
                       od.titre as objet_demande_titre,
                       u.nom as destinataire_nom,
                       u.email as destinataire_email
                FROM propositions p
                LEFT JOIN objets op ON p.objet_propose_id = op.id
                LEFT JOIN objets od ON p.objet_demande_id = od.id
                LEFT JOIN users u ON p.user_destinataire_id = u.id
                WHERE p.user_proposant_id = ?";
        
        $params = [$userId];
        
        if ($statut) {
            $sql .= " AND p.statut = ?";
            $params[] = $statut;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        return $this->query($sql, $params);
    }
    
    /**
     * Récupérer l'historique des échanges d'un utilisateur
     */
    public function getEchanges($userId) {
        $sql = "SELECT e.*, 
                       o1.titre as objet1_titre,
                       o2.titre as objet2_titre,
                       u1.nom as user1_nom,
                       u2.nom as user2_nom
                FROM echanges e
                LEFT JOIN objets o1 ON e.objet1_id = o1.id
                LEFT JOIN objets o2 ON e.objet2_id = o2.id
                LEFT JOIN users u1 ON e.user1_id = u1.id
                LEFT JOIN users u2 ON e.user2_id = u2.id
                WHERE e.user1_id = ? OR e.user2_id = ?
                ORDER BY e.created_at DESC";
        
        return $this->query($sql, [$userId, $userId]);
    }
    
    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile($userId, $data) {
        // Ne pas permettre la modification de l'email et du rôle via cette méthode
        unset($data['email'], $data['role'], $data['password']);
        
        return $this->update($userId, $data);
    }
    
    /**
     * Changer le mot de passe
     */
    public function changePassword($userId, $oldPassword, $newPassword) {
        $user = $this->find($userId);
        
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return false;
        }
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
}
