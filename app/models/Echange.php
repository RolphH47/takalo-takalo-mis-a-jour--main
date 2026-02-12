<?php

namespace App\Models;

use PDO;

class Echange extends Model {
    
    protected $table = 'echanges';
    
    /**
     * Récupérer les détails d'un échange
     */
    public function getDetails($echangeId) {
        $sql = "SELECT e.*, 
                       o1.titre as objet1_titre,
                       o2.titre as objet2_titre,
                       u1.nom as user1_nom, u1.email as user1_email,
                       u2.nom as user2_nom, u2.email as user2_email
                FROM echanges e
                LEFT JOIN objets o1 ON e.objet1_id = o1.id
                LEFT JOIN objets o2 ON e.objet2_id = o2.id
                LEFT JOIN users u1 ON e.user1_id = u1.id
                LEFT JOIN users u2 ON e.user2_id = u2.id
                WHERE e.id = ?";
        
        $result = $this->query($sql, [$echangeId]);
        return $result[0] ?? null;
    }
    
    /**
     * Compter les échanges pour les statistiques admin
     */
    public function getTotalEchanges() {
        return $this->count();
    }
}

class HistoriqueObjet extends Model {
    
    protected $table = 'historique_objets';
    
    /**
     * Récupérer l'historique d'un objet
     */
    public function getHistorique($objetId) {
        $sql = "SELECT h.*, 
                       ua.nom as ancien_proprio_nom,
                       un.nom as nouveau_proprio_nom,
                       e.date_echange
                FROM historique_objets h
                LEFT JOIN users ua ON h.user_ancien_id = ua.id
                LEFT JOIN users un ON h.user_nouveau_id = un.id
                LEFT JOIN echanges e ON h.echange_id = e.id
                WHERE h.objet_id = ?
                ORDER BY h.date_changement DESC";
        
        return $this->query($sql, [$objetId]);
    }
}
