# 🛣️ Routes Takalo-Takalo

## 📍 Routes publiques (Accessibles sans connexion)

### Page d'accueil
```
GET  /                      Afficher la liste des objets disponibles
                           Vue: home/index.php
                           Controller: HomeController@index
```

### Détails d'un objet
```
GET  /objets/{id}          Afficher les détails d'un objet
                           Vue: home/show.php
                           Controller: HomeController@show
                           Exemple: /objets/1
```

### Authentification
```
GET  /register             Afficher le formulaire d'inscription
                           Vue: auth/register.php
                           Layout: guest.php
                           Controller: AuthController@registerForm

POST /register             Traiter l'inscription
                           Controller: AuthController@register
                           Redirection: /login (succès)

GET  /login                Afficher le formulaire de connexion
                           Vue: auth/login.php
                           Layout: guest.php
                           Controller: AuthController@loginForm

POST /login                Traiter la connexion
                           Controller: AuthController@login
                           Redirection: / (user) ou /admin/dashboard (admin)

GET  /logout               Se déconnecter
                           Controller: AuthController@logout
                           Redirection: /login
```

---

## 🔒 Routes utilisateur (Nécessite authentification)

### Gestion des objets

#### Liste de mes objets
```
GET  /mes-objets           Afficher tous mes objets
                           Vue: objets/mes-objets.php
                           Controller: ObjetController@mesobjets
                           Middleware: isAuthenticated
```

#### Créer un objet
```
GET  /objets/create        Afficher le formulaire d'ajout
                           Vue: objets/create.php
                           Controller: ObjetController@create

POST /objets               Enregistrer le nouvel objet
                           Controller: ObjetController@store
                           Upload: photos[]
                           Redirection: /mes-objets
```

#### Modifier un objet
```
GET  /objets/{id}/edit     Afficher le formulaire de modification
                           Vue: objets/edit.php
                           Controller: ObjetController@edit
                           Exemple: /objets/5/edit

POST /objets/{id}/update   Enregistrer les modifications
                           Controller: ObjetController@update
                           Upload: photos[] (optionnel)
                           Redirection: /mes-objets
                           Exemple: /objets/5/update
```

#### Supprimer un objet
```
POST /objets/{id}/delete   Supprimer un objet
                           Controller: ObjetController@delete
                           Redirection: /mes-objets
                           Exemple: /objets/5/delete
```

---

### Gestion des propositions d'échange

#### Liste des propositions
```
GET  /propositions         Afficher mes propositions (reçues + envoyées)
                           Vue: propositions/index.php
                           Controller: PropositionController@index
```

#### Créer une proposition
```
GET  /propositions/create/{objetDemandeId}
                           Afficher le formulaire de proposition
                           Vue: propositions/create.php
                           Controller: PropositionController@create
                           Exemple: /propositions/create/8

POST /propositions         Enregistrer la proposition
                           Controller: PropositionController@store
                           Données: objet_propose_id, objet_demande_id, message
                           Redirection: /propositions
```

#### Accepter une proposition (propriétaire de l'objet demandé)
```
POST /propositions/{id}/accepter
                           Accepter une proposition reçue
                           Controller: PropositionController@accepter
                           Actions: 
                           - Créer un échange
                           - Transférer la propriété des objets
                           - Ajouter à l'historique
                           Redirection: /propositions
                           Exemple: /propositions/3/accepter
```

#### Refuser une proposition (propriétaire de l'objet demandé)
```
POST /propositions/{id}/refuser
                           Refuser une proposition reçue
                           Controller: PropositionController@refuser
                           Redirection: /propositions
                           Exemple: /propositions/3/refuser
```

---

## 👑 Routes admin (Nécessite rôle admin)

### Dashboard
```
GET  /admin/dashboard      Tableau de bord administrateur
                           Vue: admin/dashboard.php
                           Layout: admin.php
                           Controller: AdminController@dashboard
                           Affiche: statistiques (users, objets, échanges)
```

### Gestion des catégories

#### Liste des catégories
```
GET  /admin/categories     Afficher toutes les catégories
                           Vue: admin/categories.php
                           Controller: AdminController@categories
```

#### Créer une catégorie
```
POST /admin/categories     Créer une nouvelle catégorie
                           Controller: AdminController@createCategory
                           Données: nom, description, icone
                           Redirection: /admin/categories
```

#### Supprimer une catégorie
```
POST /admin/categories/{id}/delete
                           Supprimer une catégorie
                           Controller: AdminController@deleteCategory
                           Note: Impossible si des objets utilisent cette catégorie
                           Redirection: /admin/categories
                           Exemple: /admin/categories/5/delete
```

---

## 📊 Résumé des routes

### Par type HTTP
- **GET** : 11 routes (affichage)
- **POST** : 9 routes (traitement)
- **Total** : 20 routes

### Par section
- **Public** : 4 routes (/, /objets/{id}, /register, /login)
- **Auth** : 3 routes (/register, /login, /logout)
- **Utilisateur** : 10 routes (objets, propositions)
- **Admin** : 3 routes (dashboard, catégories)

---

## 🔐 Middlewares (à implémenter si souhaité)

### Middleware d'authentification
```php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    Flight::redirect('/login');
    return;
}
```

### Middleware admin
```php
// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    Flight::redirect('/login');
    return;
}
```

### Middleware propriétaire d'objet
```php
// Vérifier si l'utilisateur est propriétaire de l'objet
$objet = $objetModel->find($id);
if ($objet['user_id'] != $_SESSION['user']['id']) {
    Flight::redirect('/mes-objets');
    return;
}
```

---

## 🧪 Tests des routes

### Test rapide avec cURL

```bash
# Page d'accueil
curl http://localhost:8000/

# Détails objet
curl http://localhost:8000/objets/1

# Login (POST)
curl -X POST http://localhost:8000/login \
  -d "email=rakoto@gmail.com&password=password123"

# Mes objets (nécessite session)
curl -b cookies.txt http://localhost:8000/mes-objets
```

---

## 📝 Notes importantes

1. **BASE_URL** : Toutes les routes utilisent `BASE_URL` dans les vues
   ```php
   <a href="<?= BASE_URL ?>/mes-objets">Mes objets</a>
   ```

2. **Paramètres dans les routes** :
   - `{id}` : ID de l'objet
   - `{objetDemandeId}` : ID de l'objet qu'on veut recevoir

3. **Méthodes HTTP** :
   - GET : Affichage (ne modifie pas de données)
   - POST : Actions (création, modification, suppression)

4. **Redirections après POST** :
   - Toujours rediriger après un POST (pattern POST-REDIRECT-GET)
   - Évite la resoumission du formulaire au F5

5. **Messages flash** :
   - Utiliser `Flight::set('success', ...)` ou `Flight::set('error', ...)`
   - Affichés automatiquement dans le layout

---

## 🎯 Exemples d'utilisation

### Scénario 1 : Utilisateur ajoute un objet
```
1. GET  /objets/create          Afficher le formulaire
2. POST /objets                 Soumettre le formulaire
3. REDIRECT /mes-objets         Voir l'objet ajouté
```

### Scénario 2 : Utilisateur propose un échange
```
1. GET  /                       Voir les objets disponibles
2. GET  /objets/8               Voir les détails d'un objet
3. GET  /propositions/create/8  Créer une proposition
4. POST /propositions           Envoyer la proposition
5. REDIRECT /propositions       Voir la proposition envoyée
```

### Scénario 3 : Acceptation d'un échange
```
1. GET  /propositions           Voir les propositions reçues
2. POST /propositions/3/accepter  Accepter la proposition
3. REDIRECT /propositions       Voir l'échange effectué
```

---

**Fichier de référence - Février 2026**
