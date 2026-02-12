<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Objet;
use App\Models\Echange;
use Flight;

class AdminController {
    
    /**
     * Dashboard admin
     */
    public function dashboard() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            Flight::redirect('/login');
            return;
        }
        
        $userModel = new User();
        $objetModel = new Objet();
        $echangeModel = new Echange();
        
        $stats = [
            'total_users' => $userModel->count(),
            'total_objets' => $objetModel->count(),
            'total_echanges' => $echangeModel->getTotalEchanges(),
            'objets_disponibles' => $objetModel->count('statut', 'disponible')
        ];
        
        Flight::set('stats', $stats);
        Flight::render('admin/dashboard', [], 'content');
        Flight::render('layout/admin');
    }
    
    /**
     * Gestion des catégories
     */
    public function categories() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            Flight::redirect('/login');
            return;
        }
        
        $categoryModel = new Category();
        $categories = $categoryModel->getAllWithCount();
        
        Flight::set('categories', $categories);
        Flight::render('admin/categories', [], 'content');
        Flight::render('layout/admin');
    }
    
    /**
     * Créer une catégorie
     */
    public function createCategory() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            Flight::redirect('/login');
            return;
        }
        
        $categoryModel = new Category();
        $data = [
            'nom' => Flight::request()->data->nom,
            'description' => Flight::request()->data->description ?? '',
            'icone' => Flight::request()->data->icone ?? 'bi-tag'
        ];
        
        $categoryModel->create($data);
        Flight::set('success', "Catégorie créée avec succès !");
        Flight::redirect('/admin/categories');
    }
    
    /**
     * Supprimer une catégorie
     */
    public function deleteCategory($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            Flight::redirect('/login');
            return;
        }
        
        $categoryModel = new Category();
        $categoryModel->delete($id);
        
        Flight::set('success', "Catégorie supprimée !");
        Flight::redirect('/admin/categories');
    }
}
