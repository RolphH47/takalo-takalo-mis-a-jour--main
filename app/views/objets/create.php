<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Ajouter un nouvel objet</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL ?>/objets" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Titre de l'objet *</label>
                            <input type="text" name="titre" class="form-control" required 
                                   placeholder="Ex: Veste en cuir noire taille M">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Catégorie *</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Choisir une catégorie --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>">
                                            <?= htmlspecialchars($cat['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">État *</label>
                                <select name="etat" class="form-select" required>
                                    <option value="neuf">Neuf</option>
                                    <option value="tres_bon">Très bon état</option>
                                    <option value="bon" selected>Bon état</option>
                                    <option value="acceptable">État acceptable</option>
                                    <option value="usage">Usagé</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control" rows="5" required
                                      placeholder="Décrivez votre objet en détail..."></textarea>
                            <small class="text-muted">Soyez précis pour faciliter l'échange</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix estimatif (optionnel)</label>
                            <div class="input-group">
                                <input type="number" name="prix_estimatif" class="form-control" 
                                       placeholder="Ex: 50000" min="0" step="100">
                                <span class="input-group-text">Ar</span>
                            </div>
                            <small class="text-muted">Indiquez une estimation pour faciliter les échanges équitables</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Photos</label>
                            <input type="file" name="photos[]" class="form-control" accept="image/*" multiple>
                            <small class="text-muted">Vous pouvez ajouter plusieurs photos (JPG, PNG, GIF). La première sera la photo principale.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Publier l'objet
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
