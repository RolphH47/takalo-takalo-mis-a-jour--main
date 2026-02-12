<?php

namespace App\Models;

use PDO;

class Category extends Model {
    
    protected $table = 'categories';
    
    /**
     * Récupérer toutes les catégories avec le nombre d'objets
     */
    public function getAllWithCount() {
        $sql = "SELECT c.*, COUNT(o.id) as objets_count
                FROM categories c
                LEFT JOIN objets o ON c.id = o.category_id AND o.statut = 'disponible'
                GROUP BY c.id
                ORDER BY c.nom ASC";
        
        return $this->query($sql);
    }
    
    /**
     * Récupérer les objets d'une catégorie
     */
    public function getObjets($categoryId, $statut = 'disponible') {
        $sql = "SELECT o.*, u.nom as proprietaire_nom
                FROM objets o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.category_id = ? AND o.statut = ?
                ORDER BY o.created_at DESC";
        
        return $this->query($sql, [$categoryId, $statut]);
    }
}
