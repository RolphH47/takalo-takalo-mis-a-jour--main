<?php

namespace App\Controllers;

use App\Models\User;
use Flight;

class AuthController {
    
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Afficher le formulaire d'inscription
     */
    public function registerForm() {
        Flight::render('auth/register', [], 'content');
        Flight::render('layout/guest');
    }
    
    /**
     * Traiter l'inscription
     */
    public function register() {
        $nom = Flight::request()->data->nom;
        $prenom = Flight::request()->data->prenom;
        $email = Flight::request()->data->email;
        $password = Flight::request()->data->password;
        $password_confirm = Flight::request()->data->password_confirm;
        $telephone = Flight::request()->data->telephone;
        $adresse = Flight::request()->data->adresse;
        
        // Validation
        $errors = [];
        
        if (empty($nom)) $errors[] = "Le nom est requis";
        if (empty($email)) $errors[] = "L'email est requis";
        if (empty($password)) $errors[] = "Le mot de passe est requis";
        if ($password !== $password_confirm) $errors[] = "Les mots de passe ne correspondent pas";
        if ($this->userModel->emailExists($email)) $errors[] = "Cet email est déjà utilisé";
        
        if (!empty($errors)) {
            Flight::set('errors', $errors);
            Flight::set('old', Flight::request()->data->getData());
            return $this->registerForm();
        }
        
        // Créer l'utilisateur
        $userId = $this->userModel->register([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'telephone' => $telephone,
            'adresse' => $adresse
        ]);
        
        if ($userId) {
            Flight::set('success', "Inscription réussie ! Vous pouvez maintenant vous connecter.");
            Flight::redirect('/login');
        } else {
            Flight::set('errors', ["Une erreur s'est produite lors de l'inscription"]);
            return $this->registerForm();
        }
    }
    
    /**
     * Afficher le formulaire de connexion
     */
    public function loginForm() {
        Flight::render('auth/login', [], 'content');
        Flight::render('layout/guest');
    }
    
    /**
     * Traiter la connexion
     */
    public function login() {
        $email = Flight::request()->data->email;
        $password = Flight::request()->data->password;
        
        $user = $this->userModel->authenticate($email, $password);
        
        if ($user) {
            // Démarrer la session
            $_SESSION['user'] = $user;
            $_SESSION['logged_in'] = true;
            
            // Rediriger selon le rôle
            if ($user['role'] === 'admin') {
                Flight::redirect('/');
            } else {
                Flight::redirect('/');
            }
        } else {
            Flight::set('error', "Email ou mot de passe incorrect");
            Flight::set('old_email', $email);
            return $this->loginForm();
        }
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        Flight::redirect('/login');
    }
}
