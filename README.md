# Takalo-Takalo - Plateforme d'échange d'objets

Projet réalisé avec **FlightPHP MVC** - Plateforme d'échange d'objets entre particuliers à Madagascar.

## 📋 Cahier des charges

### Objectif
Créer un site web permettant aux utilisateurs d'échanger des objets (vêtements, livres, DVD, etc.) entre eux. Les utilisateurs inscrits peuvent mettre en ligne leurs objets et proposer des échanges avec d'autres utilisateurs.

### Technologies
- **Framework PHP** : FlightPHP
- **Base de données** : MySQL/PostgreSQL
- **Frontend** : Bootstrap 5
- **Architecture** : MVC avec inclusion inversée

## 🚀 Installation

### Prérequis
- PHP 8.0+
- MySQL/MariaDB
- Composer
- Serveur web (Apache/Nginx) ou PHP built-in server

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone [votre-repo]
cd takalo-takalo
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer la base de données**
```bash
# Créer la base de données
mysql -u root -p < database.sql

# Ou importer via phpMyAdmin
```

4. **Configuration**
```bash
# Copier et éditer le fichier de configuration
cp app/config/config_sample.php app/config/config.php
# Éditer app/config/config.php avec vos paramètres de BDD
```

5. **Démarrer le serveur**
```bash
php -S localhost:8000 -t public
```

6. **Accéder à l'application**
```
http://localhost:8000
```

### Comptes de test

**Administrateur**
- Email: admin@takalo.mg
- Mot de passe: admin123

**Utilisateurs**
- rakoto@gmail.com / password123
- rabe@gmail.com / password123
- rasoa@gmail.com / password123

## 📁 Structure du projet

```
takalo-takalo/
├── app/
│   ├── config/
│   │   ├── bootstrap.php    # Initialisation de l'application
│   │   ├── config.php       # Configuration (BDD, etc.)
│   │   ├── routes.php       # Définition des routes
│   │   └── services.php     # Services (BDD, session, helpers)
│   ├── controllers/
│   │   ├── AuthController.php         # Authentification
│   │   ├── HomeController.php         # Page d'accueil
│   │   ├── ObjetController.php        # Gestion des objets
│   │   ├── PropositionController.php  # Propositions d'échange
│   │   └── AdminController.php        # Administration
│   ├── models/
│   │   ├── Model.php          # Modèle de base
│   │   ├── User.php           # Utilisateurs
│   │   ├── Category.php       # Catégories
│   │   ├── Objet.php          # Objets
│   │   ├── Proposition.php    # Propositions
│   │   └── Echange.php        # Échanges effectués
│   └── views/
│       ├── layout/
│       │   ├── main.php       # Layout principal (utilisateur)
│       │   ├── admin.php      # Layout admin
│       │   └── guest.php      # Layout invité
│       ├── auth/              # Vues d'authentification
│       ├── home/              # Vues publiques
│       ├── objets/            # Vues gestion objets
│       ├── propositions/      # Vues propositions
│       └── admin/             # Vues administration
├── public/
│   ├── index.php            # Point d'entrée
│   ├── assets/              # CSS, JS, images
│   └── uploads/             # Photos uploadées
├── vendor/                  # Dépendances Composer
├── database.sql            # Schéma de base de données
└── index.php               # Point d'entrée racine
```

## 🎯 Fonctionnalités

### Backoffice (Admin)

1. **Login admin**
   - Accès : `/admin/dashboard`
   - Login par défaut sur le formulaire

2. **Gestion des catégories**
   - Créer, modifier, supprimer des catégories
   - Voir le nombre d'objets par catégorie

### Frontoffice (Utilisateur)

1. **Authentification**
   - Page d'inscription (`/register`)
   - Page de connexion (`/login`)

2. **Gestion des objets**
   - **Créer un objet** (`/objets/create`)
     - Titre, description, photos multiples, prix estimatif
   - **Mes objets** (`/mes-objets`)
     - Liste de tous mes objets
     - Modifier/Supprimer mes objets

3. **Consultation des objets**
   - **Liste publique** (`/`)
     - Tous les objets disponibles
     - Recherche par titre/catégorie
   - **Fiche objet** (`/objets/{id}`)
     - Détails complets
     - Proposer un échange

4. **Gestion des échanges**
   - **Mes propositions** (`/propositions`)
     - Propositions reçues
     - Propositions envoyées
     - Acceptation/Refus

### Fonctionnalités avancées

1. **Statistiques (Admin)**
   - Nombre d'utilisateurs inscrits
   - Nombre d'échanges effectués

2. **Barre de recherche** (Frontoffice)
   - Recherche par mot-clé
   - Filtrage par catégorie

3. **Historique des objets** (Frontoffice)
   - Voir les différents propriétaires au fil des échanges
   - Date et heure de chaque échange

## 🗃️ Base de données

### Tables principales

- **users** : Utilisateurs du système
- **categories** : Catégories d'objets
- **objets** : Objets proposés à l'échange
- **photos_objets** : Photos des objets (plusieurs par objet)
- **propositions** : Propositions d'échange entre utilisateurs
- **echanges** : Échanges effectués
- **historique_objets** : Historique des propriétaires

### Statuts

**Objets** :
- `disponible` : Disponible pour l'échange
- `en_echange` : Proposition en cours
- `echange` : Déjà échangé
- `retire` : Retiré par le propriétaire

**Propositions** :
- `en_attente` : En attente de réponse
- `accepte` : Acceptée (échange effectué)
- `refuse` : Refusée
- `annule` : Annulée par le proposant

## 🔐 Sécurité

- Mots de passe hashés avec `password_hash()`
- Protection CSRF (à implémenter)
- Validation des données utilisateur
- Vérification des propriétaires avant modification/suppression
- Sessions sécurisées

## 📝 Routes principales

### Publiques
```
GET  /                          # Page d'accueil
GET  /objets/{id}              # Détails d'un objet
GET  /register                 # Formulaire d'inscription
POST /register                 # Traiter l'inscription
GET  /login                    # Formulaire de connexion
POST /login                    # Traiter la connexion
GET  /logout                   # Déconnexion
```

### Utilisateur (authentification requise)
```
GET  /mes-objets               # Liste de mes objets
GET  /objets/create            # Formulaire d'ajout
POST /objets                   # Enregistrer un objet
GET  /objets/{id}/edit         # Formulaire de modification
POST /objets/{id}/update       # Mettre à jour
POST /objets/{id}/delete       # Supprimer

GET  /propositions             # Mes propositions
GET  /propositions/create/{id} # Créer une proposition
POST /propositions             # Enregistrer
POST /propositions/{id}/accepter  # Accepter
POST /propositions/{id}/refuser   # Refuser
```

### Admin
```
GET  /admin/dashboard          # Tableau de bord
GET  /admin/categories         # Gestion catégories
POST /admin/categories         # Créer catégorie
POST /admin/categories/{id}/delete  # Supprimer
```

## 🎨 Principes de développement

### Inclusion inversée
Le projet utilise le principe d'**inclusion inversée** :
- Le layout principal (`main.php`) inclut le contenu
- Les vues ne contiennent que le contenu spécifique
- Pas de duplication de code HTML

### Architecture MVC
- **Models** : Logique métier et accès aux données
- **Views** : Présentation (HTML/PHP)
- **Controllers** : Logique de l'application

## 📧 Contact

ETU 1770 - P18/P5DS - Février 2026

---

**Note** : Ce projet est réalisé dans un cadre pédagogique.
