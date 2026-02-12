<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ObjetController;
use App\Controllers\PropositionController;
use App\Controllers\AdminController;

/**
 * ROUTES PUBLIQUES
 */

// Page d'accueil - Liste des objets
$router->get('/', [new HomeController(), 'index']);
$router->get('/objets/@id', [new HomeController(), 'show']);

// Authentification
$router->get('/register', [new AuthController(), 'registerForm']);
$router->post('/register', [new AuthController(), 'register']);
$router->get('/login', [new AuthController(), 'loginForm']);
$router->post('/login', [new AuthController(), 'login']);
$router->get('/logout', [new AuthController(), 'logout']);

/**
 * ROUTES UTILISATEUR (nécessite authentification)
 */

// Gestion des objets
$router->get('/mes-objets', [new ObjetController(), 'mesobjets']);
$router->get('/objets/create', [new ObjetController(), 'create']);
$router->post('/objets', [new ObjetController(), 'store']);
$router->get('/objets/@id/edit', [new ObjetController(), 'edit']);
$router->post('/objets/@id/update', [new ObjetController(), 'update']);
$router->post('/objets/@id/delete', [new ObjetController(), 'delete']);

// Gestion des propositions d'échange
$router->get('/propositions', [new PropositionController(), 'index']);
$router->get('/propositions/create/@objetDemandeId', [new PropositionController(), 'create']);
$router->post('/propositions', [new PropositionController(), 'store']);
$router->post('/propositions/@id/accepter', [new PropositionController(), 'accepter']);
$router->post('/propositions/@id/refuser', [new PropositionController(), 'refuser']);

/**
 * ROUTES ADMIN (nécessite rôle admin)
 */

// Dashboard admin
$router->get('/admin/dashboard', [new AdminController(), 'dashboard']);

// Gestion des catégories
$router->get('/admin/categories', [new AdminController(), 'categories']);
$router->post('/admin/categories', [new AdminController(), 'createCategory']);
$router->post('/admin/categories/@id/delete', [new AdminController(), 'deleteCategory']);
