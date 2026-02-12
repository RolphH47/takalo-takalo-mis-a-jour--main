<?php

namespace App\Controllers;

use App\Models\Objet;
use App\Models\Category;
use App\Models\User;
use Flight;

class HomeController {
    
    private $objetModel;
    private $categoryModel;
    
    public function __construct() {
        $this->objetModel = new Objet();
        $this->categoryModel = new Category();
    }
    
    /**
     * Page d'accueil - Liste des objets disponibles
     */
    public function index() {
    $search = Flight::request()->query->search ?? null;
    $categoryId = Flight::request()->query->category ?? null;
    
    $objets = $this->objetModel->getAllDisponibles($search, $categoryId);
    $categories = $this->categoryModel->getAllWithCount();
    
    Flight::render('home/index', [
        'objets' => $objets,
        'categories' => $categories,
        'search' => $search,
        'selectedCategory' => $categoryId
    ], 'content');
    Flight::render('layout/main');

    }
    
    /**
     * Détails d'un objet
     */
    public function show($id) {
        $objet = $this->objetModel->getDetails($id);
        
        if (!$objet) {
            Flight::notFound();
            return;
        }
        
        $photos = $this->objetModel->getPhotos($id);
        $historique = (new \App\Models\HistoriqueObjet())->getHistorique($id);
        
        Flight::render('home/show', [
            'objet' => $objet,
            'photos' => $photos,
            'historique' => $historique
        ], 'content');
        Flight::render('layout/main');
    }

}
