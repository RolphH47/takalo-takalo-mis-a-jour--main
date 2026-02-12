<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="bi bi-box-seam"></i> Mes objets</h1>
            <p class="text-muted">Gérez vos objets proposés à l'échange</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= BASE_URL ?>/objets/create" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Ajouter un objet
            </a>
        </div>
    </div>

    <?php if (empty($objets)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-box-seam fs-1"></i>
            <h4 class="mt-3">Vous n'avez pas encore d'objets</h4>
            <p class="text-muted">Commencez par ajouter un objet que vous souhaitez échanger</p>
            <a href="<?= BASE_URL ?>/objets/create" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Ajouter mon premier objet
            </a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($objets as $objet): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($objet['titre']) ?></h5>
                                <?php
                                $statusBadges = [
                                    'disponible' => 'success',
                                    'en_echange' => 'warning',
                                    'echange' => 'info',
                                    'retire' => 'secondary'
                                ];
                                ?>
                                <span class="badge bg-<?= $statusBadges[$objet['statut']] ?>">
                                    <?= ucfirst($objet['statut']) ?>
                                </span>
                            </div>

                            <p class="card-text text-muted small mb-2">
                                <i class="bi bi-tag"></i> <?= htmlspecialchars($objet['categorie_nom']) ?>
                            </p>

                            <p class="card-text"><?= substr(htmlspecialchars($objet['description']), 0, 100) ?>...</p>

                            <div class="mb-3">
                                <strong class="text-primary">
                                    <?= $objet['prix_estimatif'] ? number_format($objet['prix_estimatif'], 0, ',', ' ') . ' Ar' : 'À évaluer' ?>
                                </strong>
                            </div>

                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($objet['created_at'])) ?>
                            </small>
                        </div>

                        <div class="card-footer bg-white">
                            <div class="d-flex gap-2">
                                <a href="<?= BASE_URL ?>/objets/<?= $objet['id'] ?>" class="btn btn-sm btn-outline-info flex-fill">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="<?= BASE_URL ?>/objets/<?= $objet['id'] ?>/edit" class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form method="POST" action="<?= BASE_URL ?>/objets/<?= $objet['id'] ?>/delete" class="flex-fill">
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objet ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
