<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/mes-objets">Mes objets</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Modifier l'objet</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL ?>/objets/<?= $objet['id'] ?>/update" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Titre de l'objet *</label>
                            <input type="text" name="titre" class="form-control" required 
                                   value="<?= htmlspecialchars($objet['titre']) ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Catégorie *</label>
                                <select name="category_id" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $objet['category_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">État *</label>
                                <select name="etat" class="form-select" required>
                                    <option value="neuf" <?= $objet['etat'] == 'neuf' ? 'selected' : '' ?>>Neuf</option>
                                    <option value="tres_bon" <?= $objet['etat'] == 'tres_bon' ? 'selected' : '' ?>>Très bon état</option>
                                    <option value="bon" <?= $objet['etat'] == 'bon' ? 'selected' : '' ?>>Bon état</option>
                                    <option value="acceptable" <?= $objet['etat'] == 'acceptable' ? 'selected' : '' ?>>État acceptable</option>
                                    <option value="usage" <?= $objet['etat'] == 'usage' ? 'selected' : '' ?>>Usagé</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($objet['description']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix estimatif (optionnel)</label>
                            <div class="input-group">
                                <input type="number" name="prix_estimatif" class="form-control" 
                                       value="<?= $objet['prix_estimatif'] ?>" min="0" step="100">
                                <span class="input-group-text">Ar</span>
                            </div>
                        </div>

                        <!-- Photos existantes -->
                        <?php if (!empty($photos)): ?>
                            <div class="mb-3">
                                <label class="form-label">Photos actuelles</label>
                                <div class="row g-2">
                                    <?php foreach ($photos as $photo): ?>
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($photo['chemin']) ?>" 
                                                     class="img-thumbnail" alt="Photo">
                                                <?php if ($photo['est_principale']): ?>
                                                    <span class="badge bg-primary position-absolute top-0 start-0 m-1">
                                                        Principale
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="form-label">Ajouter des photos</label>
                            <input type="file" name="photos[]" class="form-control" accept="image/*" multiple>
                            <small class="text-muted">Sélectionnez plusieurs fichiers pour ajouter de nouvelles photos</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Enregistrer les modifications
                            </button>
                            <a href="<?= BASE_URL ?>/mes-objets" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
