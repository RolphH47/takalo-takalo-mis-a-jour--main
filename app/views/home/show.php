<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Accueil</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($objet['titre']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Galerie photos -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body p-0">
                    <?php if (!empty($photos)): ?>
                        <!-- Photo principale -->
                        <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($photos as $index => $photo): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($photo['chemin']) ?>" 
                                             class="d-block w-100" 
                                             alt="Photo <?= $index + 1 ?>"
                                             style="height: 400px; object-fit: cover;">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($photos) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselPhotos" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselPhotos" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Détails de l'objet -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title"><?= htmlspecialchars($objet['titre']) ?></h2>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary me-2">
                            <i class="bi bi-tag"></i> <?= htmlspecialchars($objet['categorie_nom']) ?>
                        </span>
                        <span class="badge bg-success">
                            <i class="bi bi-star"></i> <?= ucfirst(str_replace('_', ' ', $objet['etat'])) ?>
                        </span>
                    </div>

                    <div class="mb-3">
                        <h5>Prix estimatif</h5>
                        <p class="text-primary fs-4 mb-0">
                            <?= $objet['prix_estimatif'] ? number_format($objet['prix_estimatif'], 0, ',', ' ') . ' Ar' : 'À évaluer' ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h5>Description</h5>
                        <p class="text-muted"><?= nl2br(htmlspecialchars($objet['description'])) ?></p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6><i class="bi bi-person-circle"></i> Propriétaire</h6>
                        <p class="mb-0"><?= htmlspecialchars($objet['proprietaire_nom']) ?></p>
                        <?php if ($objet['proprietaire_email']): ?>
                            <small class="text-muted"><?= htmlspecialchars($objet['proprietaire_email']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> Publié le <?= date('d/m/Y', strtotime($objet['created_at'])) ?>
                        </small>
                    </div>

                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($objet['user_id'] == $_SESSION['user']['id']): ?>
                            <!-- C'est mon objet -->
                            <div class="d-grid gap-2">
                                <a href="<?= BASE_URL ?>/objets/<?= $objet['id'] ?>/edit" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Modifier cet objet
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Proposer un échange -->
                            <div class="d-grid gap-2">
                                <a href="<?= BASE_URL ?>/propositions/create/<?= $objet['id'] ?>" class="btn btn-primary btn-lg">
                                    <i class="bi bi-arrow-left-right"></i> Proposer un échange
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <a href="<?= BASE_URL ?>/login">Connectez-vous</a> pour proposer un échange
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique de l'objet -->
    <?php if (!empty($historique)): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Historique d'appartenance</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <?php foreach ($historique as $h): ?>
                                <div class="timeline-item mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-arrow-right-circle-fill text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">
                                                <strong><?= htmlspecialchars($h['nouveau_proprio_nom']) ?></strong>
                                                <?php if ($h['ancien_proprio_nom']): ?>
                                                    a reçu cet objet de <strong><?= htmlspecialchars($h['ancien_proprio_nom']) ?></strong>
                                                <?php else: ?>
                                                    a ajouté cet objet
                                                <?php endif; ?>
                                            </p>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i> 
                                                <?= date('d/m/Y à H:i', strtotime($h['date_changement'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
