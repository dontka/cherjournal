# Phase 1 – Fondations techniques et infrastructure

## 1. Objectif

Cette phase a permis de poser la base technique et structurelle du projet Cher Journal, avec une architecture Laravel moderne, une base de données solide, une authentification sécurisée et une base de développement cohérente pour les phases suivantes.

## 2. Stack retenue

- Laravel 13
- PHP 8.4
- MySQL
- Laravel Breeze
- Livewire
- Tailwind CSS
- Vite
- PHPUnit pour les tests

## 3. État initial du projet

Le projet a été initialisé dans le dossier de travail local puis les dépendances ont été installées. Une première difficulté a été rencontrée lors de l’installation Composer sur Windows, liée à des fichiers de cache temporaires bloqués, puis résolue avant de poursuivre le développement.

## 4. Éléments mis en place

### 4.1 Base Laravel et installation de l’écosystème

Les étapes suivantes ont été réalisées :

- création du projet Laravel ;
- installation des dépendances Composer ;
- vérification de la version Laravel ;
- installation de Laravel Boost pour aider au développement et à la gouvernance du projet ;
- installation de Laravel Breeze ;
- installation de Livewire et de la stack Breeze Livewire ;
- installation des dépendances frontend NPM ;
- génération du build Vite pour vérifier le bon fonctionnement des assets.

### 4.2 Authentification et layout de base

La stack Breeze Livewire a été installée correctement, ce qui a ajouté :

- les routes d’authentification ;
- les vues de connexion, inscription, mot de passe oublié, reset password et vérification email ;
- le layout application et le layout invité ;
- le composant de navigation utilisateur ;
- le système de logout Livewire.

Les fichiers principaux concernés sont :

- routes/web.php
- routes/auth.php
- resources/views/layouts/app.blade.php
- resources/views/layouts/guest.blade.php
- resources/views/welcome.blade.php
- resources/views/livewire/layout/navigation.blade.php

### 4.3 Base de données de la Phase 1

Une fondation de données a été mise en place avec les tables suivantes :

- roles
- role_user
- categories
- emotions
- settings
- user_profiles
- user_settings

Les modèles associés ont également été ajoutés :

- App\Models\User
- App\Models\Role
- App\Models\Category
- App\Models\Emotion
- App\Models\Setting
- App\Models\UserProfile
- App\Models\UserSetting

Les relations de base ont été définies afin de préparer le système de rôles, profils utilisateur et préférences personnalisées.

## 5. Structure métier ajoutée

### 5.1 Rôles

Le système supporte désormais :

- nom du rôle ;
- slug ;
- description ;
- statut actif/inactif ;
- relation many-to-many avec les utilisateurs.

### 5.2 Catégories

Les catégories sont prêtes pour structurer les thématiques du journal, des émotions ou des contenus. Elles supportent :

- nom ;
- slug ;
- description ;
- statut actif ;
- ordre de tri.

### 5.3 Émotions

Les émotions sont définies pour permettre une taxonomie émotionnelle dans le produit, avec :

- nom ;
- slug ;
- description ;
- couleur ;
- statut actif ;
- ordre de tri.

### 5.4 Paramètres et préférences

Le système de configuration a été préparé pour gérer :

- paramètres globaux ;
- paramètres publics ;
- préférences utilisateur ;
- stockage en JSON pour les configurations dynamiques.

### 5.5 Profil utilisateur

Le profil utilisateur porte les informations de base de personnalité publique/anonyme :

- pseudo ;
- nom d’affichage ;
- avatar ;
- bio ;
- timezone ;
- visibilité publique ;
- mode anonyme.

## 6. Vérification et validation

Un test de fondation a été ajouté pour valider la santé de la base technique :

- tests/Feature/PhaseOneFoundationTest.php

Ce test vérifie que :

- la page d’accueil retourne bien un statut 200 ;
- les tables essentielles de la Phase 1 existent bien dans le schéma.

Commande de validation exécutée :

```bash
php artisan test --filter=PhaseOneFoundationTest
```

Résultat vérifié :

- 2 tests exécutés ;
- 2 tests passés ;
- 8 assertions réussies.

## 7. Résultat de la Phase 1

La Phase 1 est validée comme fondation technique de Cher Journal. Le projet est désormais prêt pour la suite du développement, notamment :

- l’authentification utilisateur avancée ;
- les profils utilisateurs enrichis ;
- la logique de confidentialité et d’anonymat ;
- la création des modules métiers de publication et de communauté.

## 8. Points à conserver pour la suite

- la structure Laravel est propre et exploitable ;
- la stack Livewire + Tailwind + Breeze est bien intégrée ;
- la base de données a une fondation claire et extensible ;
- les rôles, paramètres et profils sont prêts pour les prochaines phases ;
- les validations de base sont en place et fonctionnelles.

## 9. Référence de fichiers clés

- [routes/web.php](../routes/web.php)
- [routes/auth.php](../routes/auth.php)
- [resources/views/layouts/app.blade.php](../resources/views/layouts/app.blade.php)
- [resources/views/layouts/guest.blade.php](../resources/views/layouts/guest.blade.php)
- [app/Models/User.php](../app/Models/User.php)
- [app/Models/Role.php](../app/Models/Role.php)
- [app/Models/Category.php](../app/Models/Category.php)
- [app/Models/Emotion.php](../app/Models/Emotion.php)
- [app/Models/Setting.php](../app/Models/Setting.php)
- [app/Models/UserProfile.php](../app/Models/UserProfile.php)
- [app/Models/UserSetting.php](../app/Models/UserSetting.php)
- [tests/Feature/PhaseOneFoundationTest.php](../tests/Feature/PhaseOneFoundationTest.php)
