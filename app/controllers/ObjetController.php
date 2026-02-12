<?php

namespace App\Controllers;

use App\Models\Objet;
use App\Models\Category;
use Flight;

class ObjetController {
    
    private $objetModel;
    private $categoryModel;
    
    public function __construct() {
        $this->objetModel = new Objet();
        $this->categoryModel = new Category();
    }
    
    /**
     * Liste des objets de l'utilisateur connecté
     */
    public function mesobjets() {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        $userModel = new \App\Models\User();
        $objets = $userModel->getObjets($_SESSION['user']['id']);
        
        Flight::set('objets', $objets);
        Flight::render('objets/mes-objets', [], 'content');
        Flight::render('layout/main');
    }
    
    /**
     * Formulaire de création d'objet
     */
    public function create() {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        $categories = $this->categoryModel->all('nom'); // ou all() si tu n'as pas besoin de tri
        
        Flight::render('objets/create', [
            'categories' => $categories
        ], 'content');
        
        Flight::render('layout/main');
    }
    
    /**
     * Enregistrer un nouvel objet
     */
    public function store() {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        $data = [
            'user_id' => $_SESSION['user']['id'],
            'category_id' => Flight::request()->data->category_id,
            'titre' => Flight::request()->data->titre,
            'description' => Flight::request()->data->description,
            'prix_estimatif' => Flight::request()->data->prix_estimatif ?? null,
            'etat' => Flight::request()->data->etat,
            'statut' => 'disponible'
        ];
        
        $objetId = $this->objetModel->create($data);
        
        // Gérer les uploads de photos
        if ($objetId && isset($_FILES['photos'])) {
            $this->uploadPhotos($objetId, $_FILES['photos']);
        }
        
        Flight::set('success', "Objet ajouté avec succès !");
        Flight::redirect('/mes-objets');
    }
    
    /**
     * Modifier un objet
     */
    public function edit($id) {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        if (!$this->objetModel->isOwner($id, $_SESSION['user']['id'])) {
            Flight::redirect('/mes-objets');
            return;
        }
        
        $objet = $this->objetModel->find($id);
        $photos = $this->objetModel->getPhotos($id);
        $categories = $this->categoryModel->all('nom');
        
        Flight::set('objet', $objet);
        Flight::set('photos', $photos);
        Flight::set('categories', $categories);
        
        Flight::render('objets/edit', [], 'content');
        Flight::render('layout/main');
    }
    
    /**
     * Mettre à jour un objet
     */
    public function update($id) {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        if (!$this->objetModel->isOwner($id, $_SESSION['user']['id'])) {
            Flight::redirect('/mes-objets');
            return;
        }
        
        $data = [
            'category_id' => Flight::request()->data->category_id,
            'titre' => Flight::request()->data->titre,
            'description' => Flight::request()->data->description,
            'prix_estimatif' => Flight::request()->data->prix_estimatif ?? null,
            'etat' => Flight::request()->data->etat
        ];
        
        $this->objetModel->update($id, $data);
        
        // Gérer les nouvelles photos
        if (isset($_FILES['photos'])) {
            $this->uploadPhotos($id, $_FILES['photos']);
        }
        
        Flight::set('success', "Objet modifié avec succès !");
        Flight::redirect('/mes-objets');
    }
    
    /**
     * Supprimer un objet
     */
    public function delete($id) {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        if (!$this->objetModel->isOwner($id, $_SESSION['user']['id'])) {
            Flight::redirect('/mes-objets');
            return;
        }
        
        $this->objetModel->delete($id);
        Flight::set('success', "Objet supprimé avec succès !");
        Flight::redirect('/mes-objets');
    }
    
    /**
     * Upload de photos
     */
    private function uploadPhotos($objetId, $files) {
        $uploadDir = __DIR__ . '/../../public/uploads/objets/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        foreach ($files['tmp_name'] as $key => $tmp_name) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $filename = uniqid() . '_' . $files['name'][$key];
                $filepath = $uploadDir . $filename;
                
                if (move_uploaded_file($tmp_name, $filepath)) {
                    $estPrincipale = ($key === 0); // La première photo est principale
                    $this->objetModel->addPhoto($objetId, 'uploads/objets/' . $filename, $estPrincipale, $key);
                }
            }
        }
    }
}
