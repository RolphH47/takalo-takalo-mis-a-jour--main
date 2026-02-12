<div class="row">
    <div class="col-12">
        <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord</h1>
    </div>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Utilisateurs</h6>
                        <h2 class="mb-0"><?= $stats['total_users'] ?></h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total objets</h6>
                        <h2 class="mb-0"><?= $stats['total_objets'] ?></h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Objets disponibles</h6>
                        <h2 class="mb-0"><?= $stats['objets_disponibles'] ?></h2>
                    </div>
                    <i class="bi bi-bag-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Échanges effectués</h6>
                        <h2 class="mb-0"><?= $stats['total_echanges'] ?></h2>
                    </div>
                    <i class="bi bi-arrow-left-right fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Actions rapides</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="<?= BASE_URL ?>/admin/categories" class="list-group-item list-group-item-action">
                    <i class="bi bi-tag"></i> Gérer les catégories
                </a>
                <a href="<?= BASE_URL ?>/" class="list-group-item list-group-item-action">
                    <i class="bi bi-box"></i> Voir tous les objets
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informations</h5>
            </div>
            <div class="card-body">
                <p><strong>Version :</strong> 1.0.0</p>
                <p><strong>Framework :</strong> FlightPHP</p>
                <p><strong>Base de données :</strong> MySQL</p>
                <p class="mb-0"><strong>Dernière mise à jour :</strong> <?= date('d/m/Y') ?></p>
            </div>
        </div>
    </div>
</div>
