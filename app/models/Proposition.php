<?php

namespace App\Models;

use PDO;

class Proposition extends Model {
    
    protected $table = 'propositions';
    
    /**
     * Créer une proposition d'échange
     */
    public function creerProposition($data) {
        // Vérifier que l'utilisateur ne propose pas un échange avec lui-même
        if ($data['user_proposant_id'] == $data['user_destinataire_id']) {
            return false;
        }
        
        // Vérifier qu'il n'y a pas déjà une proposition identique en attente
        $sql = "SELECT id FROM propositions 
                WHERE objet_propose_id = ? AND objet_demande_id = ? 
                AND statut = 'en_attente'";
        $existing = $this->query($sql, [$data['objet_propose_id'], $data['objet_demande_id']]);
        
        if (!empty($existing)) {
            return false; // Proposition déjà existante
        }
        
        return $this->create($data);
    }
    
    /**
     * Récupérer les détails d'une proposition
     */
    public function getDetails($propositionId) {
        $sql = "SELECT p.*, 
                       op.titre as objet_propose_titre, op.prix_estimatif as objet_propose_prix,
                       od.titre as objet_demande_titre, od.prix_estimatif as objet_demande_prix,
                       up.nom as proposant_nom, up.email as proposant_email, up.telephone as proposant_telephone,
                       ud.nom as destinataire_nom, ud.email as destinataire_email, ud.telephone as destinataire_telephone
                FROM propositions p
                LEFT JOIN objets op ON p.objet_propose_id = op.id
                LEFT JOIN objets od ON p.objet_demande_id = od.id
                LEFT JOIN users up ON p.user_proposant_id = up.id
                LEFT JOIN users ud ON p.user_destinataire_id = ud.id
                WHERE p.id = ?";
        
        $result = $this->query($sql, [$propositionId]);
        return $result[0] ?? null;
    }
    
    /**
     * Accepter une proposition
     */
    public function accepter($propositionId, $userId) {
        $proposition = $this->getDetails($propositionId);
        
        // Vérifier que c'est bien le destinataire qui accepte
        if (!$proposition || $proposition['user_destinataire_id'] != $userId) {
            return false;
        }
        
        // Vérifier que la proposition est en attente
        if ($proposition['statut'] != 'en_attente') {
            return false;
        }
        
        // Mettre à jour le statut de la proposition
        $this->update($propositionId, ['statut' => 'accepte']);
        
        // Créer un échange
        $echangeModel = new Echange();
        $echangeId = $echangeModel->create([
            'proposition_id' => $propositionId,
            'objet1_id' => $proposition['objet_propose_id'],
            'objet2_id' => $proposition['objet_demande_id'],
            'user1_id' => $proposition['user_proposant_id'],
            'user2_id' => $proposition['user_destinataire_id']
        ]);
        
        // Mettre à jour le statut des objets
        $objetModel = new Objet();
        $objetModel->updateStatut($proposition['objet_propose_id'], 'echange');
        $objetModel->updateStatut($proposition['objet_demande_id'], 'echange');
        
        // Ajouter à l'historique
        $historiqueModel = new HistoriqueObjet();
        $historiqueModel->create([
            'objet_id' => $proposition['objet_propose_id'],
            'user_ancien_id' => $proposition['user_proposant_id'],
            'user_nouveau_id' => $proposition['user_destinataire_id'],
            'echange_id' => $echangeId
        ]);
        $historiqueModel->create([
            'objet_id' => $proposition['objet_demande_id'],
            'user_ancien_id' => $proposition['user_destinataire_id'],
            'user_nouveau_id' => $proposition['user_proposant_id'],
            'echange_id' => $echangeId
        ]);
        
        // Mettre à jour les propriétaires des objets
        $objetModel->update($proposition['objet_propose_id'], ['user_id' => $proposition['user_destinataire_id']]);
        $objetModel->update($proposition['objet_demande_id'], ['user_id' => $proposition['user_proposant_id']]);
        
        return true;
    }
    
    /**
     * Refuser une proposition
     */
    public function refuser($propositionId, $userId) {
        $proposition = $this->find($propositionId);
        
        // Vérifier que c'est bien le destinataire qui refuse
        if (!$proposition || $proposition['user_destinataire_id'] != $userId) {
            return false;
        }
        
        // Vérifier que la proposition est en attente
        if ($proposition['statut'] != 'en_attente') {
            return false;
        }
        
        return $this->update($propositionId, ['statut' => 'refuse']);
    }
    
    /**
     * Annuler une proposition
     */
    public function annuler($propositionId, $userId) {
        $proposition = $this->find($propositionId);
        
        // Vérifier que c'est bien le proposant qui annule
        if (!$proposition || $proposition['user_proposant_id'] != $userId) {
            return false;
        }
        
        // Vérifier que la proposition est en attente
        if ($proposition['statut'] != 'en_attente') {
            return false;
        }
        
        return $this->update($propositionId, ['statut' => 'annule']);
    }
}
