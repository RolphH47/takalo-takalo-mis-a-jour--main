<div class="row">
    <div class="col-md-8">
        <h1 class="mb-4"><i class="bi bi-tags"></i> Gestion des catégories</h1>
    </div>
    <div class="col-md-4 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
            <i class="bi bi-plus-lg"></i> Nouvelle catégorie
        </button>
    </div>
</div>

<!-- Liste des catégories -->
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icône</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Nombre d'objets</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= $cat['id'] ?></td>
                            <td><i class="bi <?= htmlspecialchars($cat['icone']) ?> fs-4"></i></td>
                            <td><strong><?= htmlspecialchars($cat['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($cat['description']) ?></td>
                            <td>
                                <span class="badge bg-primary"><?= $cat['objets_count'] ?> objets</span>
                            </td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>/admin/categories/<?= $cat['id'] ?>/delete" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Supprimer cette catégorie ?')"
                                            <?= $cat['objets_count'] > 0 ? 'disabled' : '' ?>>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ajouter Catégorie -->
<div class="modal fade" id="modalAddCategory" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?= BASE_URL ?>/admin/categories">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icône Bootstrap (optionnel)</label>
                        <input type="text" name="icone" class="form-control" placeholder="bi-tag">
                        <small class="text-muted">
                            Voir <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
