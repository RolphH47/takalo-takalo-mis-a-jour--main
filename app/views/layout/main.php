<?php

$isLoggedIn  = $_SESSION['logged_in'] ?? false;
$currentUser = $_SESSION['user'] ?? null;
$isAdmin     = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takalo-Takalo - Plateforme d'échange d'objets</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
        }
        
        .card-objet {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card-objet:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .objet-photo {
            height: 200px;
            object-fit: cover;
        }
        
        .badge-status {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }
        
        footer {
            background: #f8f9fa;
            margin-top: auto;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/">
                <i class="bi bi-arrow-left-right"></i> Takalo-Takalo
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/">Objets disponibles</a>
        </li>
        
        <?php if ($isLoggedIn ?? false): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/mes-objets">Mes objets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/propositions">
                    Mes propositions
                    <?php if (isset($_SESSION['propositions_count']) && $_SESSION['propositions_count'] > 0): ?>
                        <span class="badge bg-danger"><?= $_SESSION['propositions_count'] ?></span>
                    <?php endif; ?>
                </a>
            </li>
            
            <!-- Affichage du nom de l'utilisateur -->
            <li class="nav-item">
                <span class="nav-link text-muted">
                    <i class="bi bi-person-fill"></i> 
                    Bonjour, <?= htmlspecialchars($currentUser['nom'] ?? 'Utilisateur') ?>
                </span>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> Mon compte
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php if ($isAdmin ?? false): ?>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/dashboard">
                            <i class="bi bi-speedometer2"></i> Admin
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/login">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary text-white ms-2" href="<?= BASE_URL ?>/register">Inscription</a>
            </li>
        <?php endif; ?>
        <a class="dropdown-item" href="<?= BASE_URL ?>/logout">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </ul>
</div>
        </div>
    </nav>

    <!-- Messages Flash -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="container mt-3">
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Contenu principal -->
    <main class="py-4">
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-arrow-left-right"></i> Takalo-Takalo</h5>
                    <p class="text-muted">Plateforme d'échange d'objets entre particuliers</p>
                </div>
                <div class="col-md-3">
                    <h6>Liens utiles</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>/" class="text-decoration-none">Objets disponibles</a></li>
                        <li><a href="<?= BASE_URL ?>/register" class="text-decoration-none">Inscription</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Contact</h6>
                    <p class="text-muted small">
                        <i class="bi bi-envelope"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="0a6965647e6b697e4a7e6b616b6665277e6b616b666524676d">[email&#160;protected]</a><br>
                        <i class="bi bi-telephone"></i> +261 34 00 000 00
                    </p>
                </div>
            </div>
            <hr>
            <p class="text-center text-muted small mb-0">
                ETU004301/ETU004148/ETU003971
            </p>
        </div>
    </footer>

    <!-- Bootstrap J