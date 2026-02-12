<?php

namespace App\Models;

use PDO;

class Objet extends Model {
    
    protected $table = 'objets';
    
    /**
     * Récupérer tous les objets disponibles avec détails
     */
    public function getAllDisponibles($search = null, $categoryId = null, $limit = null) {
        $sql = "SELECT o.*, c.nom as categorie_nom, u.nom as proprietaire_nom,
                       (SELECT chemin FROM photos_objets WHERE objet_id = o.id AND est_principale = 1 LIMIT 1) as photo_principale
                FROM objets o
                LEFT JOIN categories c ON o.category_id = c.id
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.statut = 'disponible'";
        
        $params = [];
        
        if ($search) {
            $sql .= " AND (o.titre LIKE ? OR o.description LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        if ($categoryId) {
            $sql .= " AND o.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY o.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = (int)$limit;
        }
        
        return $this->query($sql, $params);
    }
    
    /**
     * Récupérer les détails complets d'un objet
     */
    public function getDetails($objetId) {
        $sql = "SELECT o.*, c.nom as categorie_nom, u.nom as proprietaire_nom, u.email as proprietaire_email, u.telephone as proprietaire_telephone
                FROM objets o
                LEFT JOIN categories c ON o.category_id = c.id
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.id = ?";
        
        return $this->query($sql, [$objetId])[0] ?? null;
    }
    
    /**
     * Récupérer les photos d'un objet
     */
    public function getPhotos($objetId) {
        $sql = "SELECT * FROM photos_objets WHERE objet_id = ? ORDER BY est_principale DESC, ordre ASC";
        return $this->query($sql, [$objetId]);
    }
    
    /**
     * Ajouter une photo
     */
    public function addPhoto($objetId, $chemin, $estPrincipale = false, $ordre = 0) {
        $sql = "INSERT INTO photos_objets (objet_id, chemin, est_principale, ordre) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$objetId, $chemin, $estPrincipale, $ordre]);
    }
    
    /**
     * Définir une photo comme principale
     */
    public function setPhotoPrincipale($objetId, $photoId) {
        // D'abord, retirer le statut principal de toutes les photos
        $sql1 = "UPDATE photos_objets SET est_principale = 0 WHERE objet_id = ?";
        $stmt1 = $this->db->prepare($sql1);
        $stmt1->execute([$objetId]);
        
        // Puis définir la nouvelle photo principale
        $sql2 = "UPDATE photos_objets SET est_principale = 1 WHERE id = ? AND objet_id = ?";
        $stmt2 = $this->db->prepare($sql2);
        return $stmt2->execute([$photoId, $objetId]);
    }
    
    /**
     * Vérifier si un utilisateur est propriétaire
     */
    public function isOwner($objetId, $userId) {
        $objet = $this->find($objetId);
        return $objet && $objet['user_id'] == $userId;
    }
    
    /**
     * Changer le statut d'un objet
     */
    public function updateStatut($objetId, $statut) {
        return $this->update($objetId, ['statut' => $statut]);
    }
}
