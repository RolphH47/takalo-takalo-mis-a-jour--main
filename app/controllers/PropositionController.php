<?php

namespace App\Controllers;

use App\Models\Proposition;
use App\Models\Objet;
use Flight;

class PropositionController {
    
    private $propositionModel;
    private $objetModel;
    
    public function __construct() {
        $this->propositionModel = new Proposition();
        $this->objetModel = new Objet();
    }
    
    /**
     * Liste des propositions de l'utilisateur
     */
    public function index() {

        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }

        $userModel = new \App\Models\User();

        $propositionsRecues   = $userModel->getPropositionsRecues($_SESSION['user']['id']);
        $propositionsEnvoyees = $userModel->getPropositionsEnvoyees($_SESSION['user']['id']);

        Flight::render('propositions/index', [
            'propositionsRecues'   => $propositionsRecues,
            'propositionsEnvoyees' => $propositionsEnvoyees
        ], 'content');

        Flight::render('layout/main');
    }

    
    /**
     * Créer une proposition d'échange
     */
    public function create($objetDemandeId) {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }

        $objetDemande = $this->objetModel->find($objetDemandeId);
        if (!$objetDemande) {
            Flight::notFound();
            return;
        }

        // Récupérer les infos du propriétaire
        $userModel = new \App\Models\User();
        $proprietaire = $userModel->find($objetDemande['user_id']);   // ou 'proprietaire_id' selon ta table

        // Option A : ajouter directement la clé dans $objetDemande
        $objetDemande['proprietaire_nom'] = $proprietaire['nom'] 
                                        ?? $proprietaire['username'] 
                                        ?? $proprietaire['prenom'] . ' ' . $proprietaire['nom'] 
                                        ?? 'Utilisateur';

        // Option B : passer les deux variables séparément (encore plus clair)
        // → voir solution 2 ci-dessous

        $mesObjets = $userModel->getObjets($_SESSION['user']['id'], 'disponible');

        Flight::render('propositions/create', [
            'objetDemande'  => $objetDemande,
            'mesObjets'     => $mesObjets,
            // 'proprietaire' => $proprietaire,   ← si tu choisis l'option B
        ], 'content');

        Flight::render('layout/main');
    }

    
    /**
     * Enregistrer une proposition
     */
    public function store() {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        $objetProposeId = Flight::request()->data->objet_propose_id;
        $objetDemandeId = Flight::request()->data->objet_demande_id;
        $message = Flight::request()->data->message ?? '';
        
        $objetDemande = $this->objetModel->find($objetDemandeId);
        
        $data = [
            'objet_propose_id' => $objetProposeId,
            'objet_demande_id' => $objetDemandeId,
            'user_proposant_id' => $_SESSION['user']['id'],
            'user_destinataire_id' => $objetDemande['user_id'],
            'message' => $message
        ];
        
        $propositionId = $this->propositionModel->creerProposition($data);
        
        if ($propositionId) {
            Flight::set('success', "Proposition envoyée avec succès !");
        } else {
            Flight::set('error', "Erreur lors de l'envoi de la proposition");
        }
        
        Flight::redirect('/propositions');
    }
    
    /**
     * Accepter une proposition
     */
    public function accepter($id) {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        if ($this->propositionModel->accepter($id, $_SESSION['user']['id'])) {
            Flight::set('success', "Proposition acceptée ! L'échange est effectué.");
        } else {
            Flight::set('error', "Erreur lors de l'acceptation");
        }
        
        Flight::redirect('/propositions');
    }
    
    /**
     * Refuser une proposition
     */
    public function refuser($id) {
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        
        if ($this->propositionModel->refuser($id, $_SESSION['user']['id'])) {
            Flight::set('success', "Proposition refusée");
        } else {
            Flight::set('error', "Erreur lors du refus");
        }
        
        Flight::redirect('/propositions');
    }
}
