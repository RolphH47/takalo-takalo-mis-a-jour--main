<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">
                        <i class="bi bi-arrow-left-right text-primary"></i><br>
                        Connexion
                    </h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= BASE_URL ?>/login">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $old_email ?? '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">Se connecter</button>
                        
                        <div class="text-center">
                            <p class="text-muted">Pas encore de compte ?</p>
                            <a href="<?= BASE_URL ?>/register" class="btn btn-outline-primary">Créer un compte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
