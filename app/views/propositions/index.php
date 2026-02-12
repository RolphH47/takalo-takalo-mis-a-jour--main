<div class="container">
    <h1 class="mb-4"><i class="bi bi-arrow-left-right"></i> Mes propositions d'échange</h1>

    <!-- Onglets -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#recues">
                Propositions reçues 
                <span class="badge bg-primary"><?= count($propositionsRecues) ?></span>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#envoyees">
                Propositions envoyées
                <span class="badge bg-secondary"><?= count($propositionsEnvoyees) ?></span>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Propositions reçues -->
        <div class="tab-pane fade show active" id="recues">
            <?php if (empty($propositionsRecues)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Vous n'avez pas encore reçu de propositions d'échange.
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($propositionsRecues as $prop): ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="bi bi-person"></i> 
                                        <?= htmlspecialchars($prop['proposant_nom']) ?>
                                    </span>
                                    <?php
                                    $badgeClass = [
                                        'en_attente' => 'warning',
                                        'accepte' => 'success',
                                        'refuse' => 'danger',
                                        'annule' => 'secondary'
                                    ];
                                    ?>
                                    <span class="badge bg-<?= $badgeClass[$prop['statut']] ?>">
                                        <?= ucfirst(str_replace('_', ' ', $prop['statut'])) ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6 text-center">
                                            <small class="text-muted">Il propose</small>
                                            <h6 class="text-primary"><?= htmlspecialchars($prop['objet_propose_titre']) ?></h6>
                                            <small><?= number_format($prop['objet_propose_prix'], 0, ',', ' ') ?> Ar</small>
                                        </div>
                                        <div class="col-6 text-center border-start">
                                            <small class="text-muted">Contre votre</small>
                                            <h6 class="text-success"><?= htmlspecialchars($prop['objet_demande_titre']) ?></h6>
                                            <small><?= number_format($prop['objet_demande_prix'], 0, ',', ' ') ?> Ar</small>
                                        </div>
                                    </div>

                                    <?php if ($prop['message']): ?>
                                        <div class="alert alert-light mb-3">
                                            <small><i class="bi bi-chat-quote"></i> "<?= htmlspecialchars($prop['message']) ?>"</small>
                                        </div>
                                    <?php endif; ?>

                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> 
                                        <?= date('d/m/Y à H:i', strtotime($prop['created_at'])) ?>
                                    </small>
                                </div>

                                <?php if ($prop['statut'] === 'en_attente'): ?>
                                    <div class="card-footer bg-white">
                                        <div class="d-flex gap-2">
                                            <form method="POST" action="<?= BASE_URL ?>/propositions/<?= $prop['id'] ?>/accepter" class="flex-fill">
                                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Confirmer l\'acceptation de cette proposition ?')">
                                                    <i class="bi bi-check-lg"></i> Accepter
                                                </button>
                                            </form>
                                            <form method="POST" action="<?= BASE_URL ?>/propositions/<?= $prop['id'] ?>/refuser" class="flex-fill">
                                                <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Confirmer le refus de cette proposition ?')">
                                                    <i class="bi bi-x-lg"></i> Refuser
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Propositions envoyées -->
        <div class="tab-pane fade" id="envoyees">
            <?php if (empty($propositionsEnvoyees)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Vous n'avez pas encore envoyé de propositions d'échange.
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($propositionsEnvoyees as $prop): ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="bi bi-person"></i> 
                                        À <?= htmlspecialchars($prop['destinataire_nom']) ?>
                                    </span>
                                    <?php
                                    $badgeClass = [
                                        'en_attente' => 'warning',
                                        'accepte' => 'success',
                                        'refuse' => 'danger',
                                        'annule' => 'secondary'
                                    ];
                                    ?>
                                    <span class="badge bg-<?= $badgeClass[$prop['statut']] ?>">
                                        <?= ucfirst(str_replace('_', ' ', $prop['statut'])) ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6 text-center">
                                            <small class="text-muted">Vous proposez</small>
                                            <h6 class="text-primary"><?= htmlspecialchars($prop['objet_propose_titre']) ?></h6>
                                            <small><?= number_format($prop['objet_propose_prix'], 0, ',', ' ') ?> Ar</small>
                                        </div>
                                        <div class="col-6 text-center border-start">
                                            <small class="text-muted">Contre</small>
                                            <h6 class="text-success"><?= htmlspecialchars($prop['objet_demande_titre']) ?></h6>
                                            <small><?= number_format($prop['objet_demande_prix'], 0, ',', ' ') ?> Ar</small>
                                        </div>
                                    </div>

                                    <?php if ($prop['message']): ?>
                                        <div class="alert alert-light mb-3">
                                            <small><i class="bi bi-chat-quote"></i> "<?= htmlspecialchars($prop['message']) ?>"</small>
                                        </div>
                                    <?php endif; ?>

                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> 
                                        <?= date('d/m/Y à H:i', strtotime($prop['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
