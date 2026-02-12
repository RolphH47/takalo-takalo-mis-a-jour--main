<?php

namespace App\Models;

use PDO;

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