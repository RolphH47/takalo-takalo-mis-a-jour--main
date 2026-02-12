<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Accueil</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/objets/<?= $objetDemande['id'] ?>"><?= htmlspecialchars($objetDemande['titre']) ?></a></li>
            <li class="breadcrumb-item active">Proposer un échange</li>
        </ol>
    </nav>

    <h1 class="mb-4"><i class="bi bi-arrow-left-right"></i> Proposer un échange</h1>

    <div class="row">
        <!-- Objet demandé -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-eye"></i> Objet qui vous intéresse</h5>
                </div>
                <div class="card-body">
                    <h4><?= htmlspecialchars($objetDemande['titre']) ?></h4>
                    <p class="text-muted"><?= htmlspecialchars($objetDemande['description']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-dark">
                            <?= $objetDemande['prix_estimatif'] ? number_format($objetDemande['prix_estimatif'], 0, ',', ' ') . ' Ar' : 'À évaluer' ?>
                        </span>
                        <small class="text-muted">
                            <i class="bi bi-person"></i> <?= htmlspecialchars($objetDemande['proprietaire_nom']) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de proposition -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-gift"></i> Choisissez votre objet à proposer</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($mesObjets)): ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> 
                            Vous n'avez pas d'objets disponibles pour l'échange.
                            <a href="<?= BASE_URL ?>/objets/create" class="alert-link">Ajouter un objet</a>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="<?= BASE_URL ?>/propositions">
                            <input type="hidden" name="objet_demande_id" value="<?= $objetDemande['id'] ?>">

                            <div class="mb-3">
                                <label class="form-label">Sélectionnez l'objet à proposer *</label>
                                <select name="objet_propose_id" class="form-select" required>
                                    <option value="">-- Choisir un objet --</option>
                                    <?php foreach ($mesObjets as $obj): ?>
                                        <option value="<?= $obj['id'] ?>">
                                            <?= htmlspecialchars($obj['titre']) ?> 
                                            (<?= $obj['prix_estimatif'] ? number_format($obj['prix_estimatif'], 0, ',', ' ') . ' Ar' : 'À évaluer' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message (optionnel)</label>
                                <textarea name="message" class="form-control" rows="4" 
                                          placeholder="Ajoutez un message pour expliquer pourquoi cet échange vous intéresse..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-send"></i> Envoyer la proposition
                                </button>
                                <a href="<?= BASE_URL ?>/objets/<?= $objetDemande['id'] ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Annuler
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
