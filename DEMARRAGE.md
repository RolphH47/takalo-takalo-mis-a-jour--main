# 🚀 Démarrage rapide - Takalo-Takalo

## Installation en 5 étapes

### 1. Installer les dépendances
```bash
composer install
```

### 2. Créer la base de données
```bash
mysql -u root -p -e "CREATE DATABASE takalo_takalo"
mysql -u root -p takalo_takalo < database.sql
```

### 3. Configurer
Éditer `app/config/config.php` :
```php
'database' => [
    'host' => 'localhost',
    'name' => 'takalo_takalo',
    'user' => 'root',          // ⚠️ Votre utilisateur
    'password' => '',          // ⚠️ Votre mot de passe
]
```

### 4. Permissions uploads
```bash
chmod -R 755 public/uploads
```

### 5. Lancer le serveur
```bash
php -S localhost:8000 -t public
```

Ouvrir : **http://localhost:8000**

## 🔑 Comptes de test

**Admin**
- Email: `admin@takalo.mg`
- Password: `admin123`

**Utilisateurs**
- `rakoto@gmail.com` / `password123`
- `rabe@gmail.com` / `password123`

## 📚 Documentation complète

Voir les fichiers :
- `INSTALLATION.md` - Guide détaillé
- `ROUTES.md` - Liste des routes
- `FICHIERS.md` - Architecture du projet

## 🆘 Problème ?

1. Vérifier les identifiants MySQL dans `config.php`
2. S'assurer que le dossier `vendor/` existe (composer install)
3. Vérifier les permissions du dossier `uploads/`

---

**Projet FlightPHP - Février 2026 - P18/P5DS**
