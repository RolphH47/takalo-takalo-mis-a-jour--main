<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="bi bi-box"></i> Objets disponibles</h1>
            <p class="text-muted">Découvrez les objets proposés à l'échange</p>
        </div>
        <div class="col-md-4 text-end">
            <?php if ($isLoggedIn ?? false): ?>
                <a href="<?= BASE_URL ?>/objets/create" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Ajouter un objet
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="<?= BASE_URL ?>/">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Rechercher un objet..." value="<?= htmlspecialchars($search ?? '') ?>">
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['nom']) ?> (<?= $cat['objets_count'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des objets -->
    <div class="row g-4">
        <?php if (empty($objets)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle fs-1"></i>
                    <p class="mb-0 mt-2">Aucun objet disponible pour le moment</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($objets as $objet): ?>
                <div class="col-md-4">
                    <div class="card card-objet h-100 shadow-sm">
                        <?php if ($objet['photo_principale']): ?>
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($objet['photo_principale']) ?>" 
                                 class="card-img-top objet-photo" 
                                 alt="<?= htmlspecialchars($objet['titre']) ?>">
                        <?php else: ?>
                            <div class="objet-photo bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($objet['titre']) ?></h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-tag"></i> <?= htmlspecialchars($objet['categorie_nom']) ?>
                            </p>
                            <p class="card-text"><?= substr(htmlspecialchars($objet['description']), 0, 100) ?>...</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark">
                                    <?= $objet['prix_estimatif'] ? number_format($objet['prix_estimatif'], 0, ',', ' ') . ' Ar' : 'À évaluer' ?>
                                </span>
                                <span class="badge badge-status bg-success"><?= ucfirst($objet['etat']) ?></span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> <?= htmlspecialchars($objet['proprietaire_nom']) ?>
                                </small>
                                <a href="<?= BASE_URL ?>/objets/<?= $objet['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    Voir détails <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
