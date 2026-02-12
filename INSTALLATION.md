# 🚀 Guide d'Installation - Takalo-Takalo

## Table des matières
1. [Prérequis](#prérequis)
2. [Installation pas à pas](#installation-pas-à-pas)
3. [Configuration](#configuration)
4. [Démarrage](#démarrage)
5. [Comptes de test](#comptes-de-test)
6. [Résolution des problèmes](#résolution-des-problèmes)

---

## Prérequis

### Logiciels requis
- **PHP** 8.0 ou supérieur
- **MySQL** 5.7+ ou **MariaDB** 10.3+
- **Composer** (gestionnaire de dépendances PHP)
- **Serveur web** (Apache, Nginx) OU PHP built-in server

### Extensions PHP requises
```bash
php -m | grep -E 'pdo|pdo_mysql|mbstring|json'
```

Vous devriez voir :
- pdo
- pdo_mysql
- mbstring
- json

---

## Installation pas à pas

### Étape 1 : Télécharger le projet

```bash
# Si vous avez Git
git clone [votre-repository-url] takalo-takalo
cd takalo-takalo

# OU extraire le ZIP téléchargé
unzip takalo-takalo.zip
cd takalo-takalo
```

### Étape 2 : Installer les dépendances

```bash
composer install
```

Si vous n'avez pas Composer, téléchargez-le depuis https://getcomposer.org/

### Étape 3 : Créer la base de données

#### Option A : Avec MySQL en ligne de commande

```bash
# Se connecter à MySQL
mysql -u root -p

# Dans MySQL, exécuter :
CREATE DATABASE takalo_takalo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# Importer le schéma
mysql -u root -p takalo_takalo < database.sql
```

#### Option B : Avec phpMyAdmin

1. Ouvrir phpMyAdmin (http://localhost/phpmyadmin)
2. Créer une nouvelle base de données nommée `takalo_takalo`
3. Sélectionner la base de données
4. Onglet "Importer"
5. Choisir le fichier `database.sql`
6. Cliquer sur "Exécuter"

### Étape 4 : Configuration

Éditer le fichier `app/config/config.php` :

```php
<?php

return [
    'app' => [
        'name' => 'Takalo-Takalo',
        'env' => 'development',
        'debug' => true,
        'base_url' => 'http://localhost:8000', // Adapter si nécessaire
    ],
    
    'database' => [
        'host' => 'localhost',
        'name' => 'takalo_takalo',
        'user' => 'root',              // ⚠️ Votre utilisateur MySQL
        'password' => '',              // ⚠️ Votre mot de passe MySQL
        'charset' => 'utf8mb4'
    ],
    
    // ... reste de la configuration
];
```

**⚠️ Important :** Modifiez les identifiants de base de données selon votre configuration.

### Étape 5 : Créer le dossier uploads

```bash
mkdir -p public/uploads/objets
chmod -R 755 public/uploads
```

---

## Démarrage

### Option 1 : Serveur PHP intégré (Recommandé pour le développement)

```bash
# Depuis la racine du projet
php -S localhost:8000 -t public
```

Accéder à : **http://localhost:8000**

### Option 2 : Apache/Nginx

#### Avec Apache (.htaccess déjà configuré)

1. Copier le projet dans votre dossier web (ex: `/var/www/html/takalo-takalo`)
2. Configurer un VirtualHost (optionnel) :

```apache
<VirtualHost *:80>
    ServerName takalo.local
    DocumentRoot /var/www/html/takalo-takalo/public
    
    <Directory /var/www/html/takalo-takalo/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Ajouter dans `/etc/hosts` :
```
127.0.0.1 takalo.local
```

4. Redémarrer Apache :
```bash
sudo service apache2 restart
```

Accéder à : **http://takalo.local**

---

## Comptes de test

### Compte Administrateur

- **Email:** admin@takalo.mg
- **Mot de passe:** admin123
- **Accès:** http://localhost:8000/admin/dashboard

### Comptes Utilisateurs

| Email | Mot de passe | Description |
|-------|--------------|-------------|
| rakoto@gmail.com | password123 | Utilisateur avec plusieurs objets |
| rabe@gmail.com | password123 | Utilisateur avec objets |
| rasoa@gmail.com | password123 | Utilisateur avec objets |

---

## Vérification de l'installation

### Checklist ✅

- [ ] Les dépendances Composer sont installées (`vendor/` existe)
- [ ] La base de données est créée et importée
- [ ] Le fichier `app/config/config.php` est configuré
- [ ] Le dossier `public/uploads/` existe avec les permissions 755
- [ ] Le serveur PHP est lancé
- [ ] La page d'accueil s'affiche (http://localhost:8000)
- [ ] Je peux me connecter avec un compte de test

### Test rapide

1. **Page d'accueil** - http://localhost:8000
   - Devrait afficher la liste des objets disponibles
   
2. **Connexion** - http://localhost:8000/login
   - Se connecter avec `rakoto@gmail.com` / `password123`
   
3. **Mes objets** - http://localhost:8000/mes-objets
   - Devrait afficher les objets de Rakoto
   
4. **Admin** - http://localhost:8000/admin/dashboard
   - Se connecter avec `admin@takalo.mg` / `admin123`

---

## Résolution des problèmes

### Problème : "SQLSTATE[HY000] [1045] Access denied"

**Solution :** Vérifier les identifiants MySQL dans `app/config/config.php`

```php
'database' => [
    'user' => 'root',        // Votre utilisateur
    'password' => 'votre_mot_de_passe',
]
```

### Problème : "Config file not found"

**Solution :** S'assurer que `app/config/config.php` existe (pas `config_sample.php`)

```bash
# Vérifier
ls -la app/config/config.php

# Si manquant, copier le sample
cp app/config/config_sample.php app/config/config.php
```

### Problème : Page blanche / Erreur 500

**Solution :** Activer l'affichage des erreurs

1. Éditer `app/config/bootstrap.php`
2. Ajouter au début :

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Problème : Upload de photos ne fonctionne pas

**Solution :** Vérifier les permissions du dossier

```bash
# Linux/Mac
chmod -R 755 public/uploads

# Vérifier les permissions
ls -la public/uploads
```

### Problème : "Base table or view not found"

**Solution :** Réimporter la base de données

```bash
mysql -u root -p takalo_takalo < database.sql
```

### Problème : Routes ne fonctionnent pas (404)

**Solution :**

1. **Avec PHP built-in server :** Relancer avec `-t public`
   ```bash
   php -S localhost:8000 -t public
   ```

2. **Avec Apache :** Activer mod_rewrite
   ```bash
   sudo a2enmod rewrite
   sudo service apache2 restart
   ```

---

## Structure des fichiers

```
takalo-takalo/
├── app/
│   ├── config/
│   │   ├── bootstrap.php      ✅ Ne pas modifier
│   │   ├── config.php         ⚠️ À configurer
│   │   ├── routes.php         ✅ Routes définies
│   │   └── services.php       ✅ Services configurés
│   ├── controllers/           ✅ Tous créés
│   ├── models/                ✅ Tous créés
│   └── views/                 ✅ Toutes créées
├── public/
│   ├── index.php              ✅ Point d'entrée
│   └── uploads/               ⚠️ À créer (chmod 755)
├── vendor/                    ✅ Installation Composer
├── database.sql               ✅ Schéma à importer
├── index.php                  ✅ Redirection
└── README.md                  📖 Documentation
```

---

## Fonctionnalités disponibles

### ✅ Frontoffice (Utilisateurs)

- Inscription / Connexion
- Consulter les objets disponibles
- Rechercher par titre et catégorie
- Voir les détails d'un objet
- Gérer mes objets (CRUD)
- Proposer des échanges
- Accepter / Refuser des propositions
- Historique des objets échangés

### ✅ Backoffice (Admin)

- Dashboard avec statistiques
- Gestion des catégories
- Nombre d'utilisateurs inscrits
- Nombre d'échanges effectués

---

## Support

### Documentation

- **FlightPHP :** https://flightphp.com/
- **Bootstrap 5 :** https://getbootstrap.com/
- **Bootstrap Icons :** https://icons.getbootstrap.com/

### Informations projet

- **Année :** 2026
- **Classe :** P18/P5DS
- **Framework :** FlightPHP MVC
- **Architecture :** Inclusion inversée

---

## 🎉 Bon développement !

Si tout fonctionne, vous devriez voir la page d'accueil avec les objets de test.

**Prochaines étapes :**
1. Tester toutes les fonctionnalités
2. Ajouter vos propres objets
3. Tester les échanges
4. Personnaliser le design si nécessaire

**N'oubliez pas de mettre votre nom et numéro ETU dans le footer !**
