# Phase 2 – Authentification, profils et gestion de l’identité

## 1. Objectif

Cette phase a pour objectif de sécuriser l’accès au produit, d’installer la base de gestion des comptes utilisateurs et de mettre en place une identité utilisateur claire, confidentielle et adaptée au concept de Cher Journal.

Le cœur de cette phase repose sur trois principes fondamentaux :

- sécuriser l’accès à l’application ;
- respecter l’anonymat et la confidentialité ;
- faire évoluer le profil utilisateur vers un espace personnel rassurant et fonctionnel.

## 2. Problématique métier

Cher Journal repose sur une dynamique de confiance et de sécurité. Les utilisateurs doivent pouvoir :

- créer un compte rapidement ;
- personnaliser leur profil sans exposer d’informations sensibles ;
- choisir un pseudonyme ou une identité publique adaptée ;
- gérer leur confidentialité avec clarté ;
- bénéficier d’un système d’authentification fiable et simple.

Comme la plateforme est pensée pour un espace intime, protecteur et parfois émotionnellement sensible, l’identité et la confidentialité ne peuvent pas être traitées comme des éléments secondaires. Elles sont au centre de l’expérience.

## 3. Stack technique et composants utilisés

Les éléments suivants ont été retenus pour la mise en œuvre de cette phase :

- Laravel Breeze
- Livewire
- Tailwind CSS
- Laravel authentication scaffolding
- Eloquent modèles et relations
- validation serveur Laravel
- système de profils utilisateur
- gestion des paramètres utilisateur et confidentialité

## 4. Éléments mis en place

### 4.1 Authentification complète

Le système d’authentification a été mis en place avec les composants Angular / Livewire classiques de Laravel Breeze, notamment :

- inscription utilisateur ;
- connexion sécurisée ;
- déconnexion ;
- mot de passe oublié ;
- réinitialisation du mot de passe ;
- vérification d’email ;
- redirection automatique vers le dashboard après connexion ou inscription.

Les composants associés sont principalement :

- routes/auth.php
- resources/views/livewire/pages/auth/login.blade.php
- resources/views/livewire/pages/auth/register.blade.php
- resources/views/layouts/guest.blade.php
- resources/views/livewire/layout/navigation.blade.php

### 4.2 Gestion du profil utilisateur

Le profil utilisateur a été préparé afin de permettre :

- la saisie du nom complet ;
- la création d’un pseudonyme unique ;
- la gestion de l’email principal ;
- le stockage de données de profil utiles à l’expérience personnelle ;
- l’affichage cohérent dans l’espace utilisateur.

Le modèle `User` a été enrichi pour couvrir les besoins de base autour de l’identité utilisateur, notamment avec :

- le pseudo / username ;
- les relations de profil ;
- les informations de compte ;
- la logique de création et d’assignation du profil.

### 4.3 Attributs et logique d’identité

Le système d’identité a été pensé pour distinguer clairement :

- le compte authentifié ;
- le profil public ;
- les données privées ;
- l’affichage visible dans la communauté.

Cette séparation est essentielle pour le produit. Elle permet de protéger les informations personnelles tout en gardant la possibilité de créer une présence sereine, lisible et cohérente dans l’écosystème Cher Journal.

### 4.4 Sécurité de base du compte

Les mécanismes élémentaires de sécurité ont été mis en place autour des fonctionnalités classiques Laravel :

- validation serveur sur les formulaires ;
- contraintes de mot de passe ;
- protection CSRF par le framework ;
- clôture de session lors de la déconnexion ;
- règles d’unicité sur email et pseudonyme ;
- validation des champs de type utilisateur.

## 5. Évolution prévue du profil utilisateur

Le profil ne doit pas rester un simple compte technique. Il doit devenir un espace personnel utile, crédible et rassurant, avec des composants comme :

- avatar ;
- bio courte ;
- pseudonyme public ;
- préférences de confidentialité ;
- historique d’activité ;
- paramètres de notification ;
- visibilité du profil ;
- gestion de sécurité.

À moyen terme, la logique du profil permettra de distinguer entre :

- identité publique ;
- identité interne ;
- identité du journal intime ;
- identité de soutien ou de contribution communautaire.

## 6. Modèle de confidentialité et anonymat

La confidentialité est l’un des piliers du produit.

### 6.1 Règles de conception

- les données réelles de l’utilisateur ne doivent pas être exposées dans les espaces publics ;
- les publications peuvent être publiques, privées ou anonymes selon le contexte ;
- le pseudonyme est la référence de présentation dans le front-office ;
- l’identité réelle doit rester séparée des contenus sociaux du produit ;
- le blocage, le signalement et la modération doivent être préparés dès maintenant.

### 6.2 Standards attendus

Les règles suivantes seront poursuivies dans les phases suivantes :

- visibilité configurable par publication ;
- anonymat par défaut pour les contenus sensibles ;
- masquage des données hors contexte de gestion interne ;
- suppression de compte sécurisée avec nettoyage des données.

## 7. Structure utilisateur dans le produit

### 7.1 Navigation utilisateur

Le shell de l’application connecté a été préparé pour proposer :

- un espace utilisateur distinct ;
- une navigation claire vers le journal et le profil ;
- une section de profil avec identifiant utilisateur ;
- un menu contextuel de déconnexion et gestion du compte.

### 7.2 Dashboard utilisateur

Le dashboard fonctionne comme le point d’entrée central de l’espace personnel. Il donne une première impression de :

- suivi personnel ;
- activité du compte ;
- progression et régularité ;
- accès rapide aux tâches clés ;
- architecture pensée comme un journal intime numérique.

## 8. Livrables de la phase 2

- système d’authentification Laravel Breeze fonctionnel ;
- inscription et connexion sécurisées ;
- gestion de compte et de profil utilisateur ;
- écran de profil mis en place ;
- espace utilisateur personnalisé ;
- dashboard initial ;
- séparation claire entre compte authentifié et identité publique ;
- base pour les prochaines étapes de journals et communautés.

## 9. Critères de validation

La phase 2 est considérée comme validée si :

- un utilisateur peut créer un compte ;
- un utilisateur peut se connecter et se déconnecter ;
- le mot de passe et l’email sont validés correctement ;
- le pseudonyme est unique et protégé ;
- le profil utilisateur est bien géré dans l’application ;
- l’utilisateur est redirigé vers le bon espace après connexion ;
- le dashboard est exploitable comme base de travail pour la suite ;
- la logique d’anonymat est bien structurée dans le code et la conception.

## 10. Résultat de la phase 2

La Phase 2 a posé les fondations essentielles de l’identité utilisateur de Cher Journal. Elle a permis de rendre l’application utilisable comme espace personnel sécurisé, avec une base cohérente pour :

- l’écriture de journal ;
- le développement des publications ;
- la confidentialité des contenus ;
- la future communauté et les interactions sociales.

Cette phase est donc une étape clé car elle transforme le projet d’un simple Laravel starter en un produit réellement orienté utilisateur, confiance, sécurité et gestion d’identité.

## 11. Référence de fichiers clés

- [routes/auth.php](../routes/auth.php)
- [resources/views/layouts/guest.blade.php](../resources/views/layouts/guest.blade.php)
- [resources/views/layouts/app.blade.php](../resources/views/layouts/app.blade.php)
- [resources/views/livewire/pages/auth/login.blade.php](../resources/views/livewire/pages/auth/login.blade.php)
- [resources/views/livewire/pages/auth/register.blade.php](../resources/views/livewire/pages/auth/register.blade.php)
- [resources/views/livewire/layout/navigation.blade.php](../resources/views/livewire/layout/navigation.blade.php)
- [resources/views/dashboard.blade.php](../resources/views/dashboard.blade.php)
- [resources/views/profile.blade.php](../resources/views/profile.blade.php)
- [app/Models/User.php](../app/Models/User.php)
- [app/Models/UserProfile.php](../app/Models/UserProfile.php)
- [database/seeders/DatabaseSeeder.php](../database/seeders/DatabaseSeeder.php)
