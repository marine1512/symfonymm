# Documentation du Projet : Plateforme E-Commerce de Sweatshirts
## **1. Contexte du projet**
### 1.1 Nom du Projet
**E-Commerce de Sweatshirts avec Paiement Stripe**
### 1.2 Description générale
Ce projet propose une boutique en ligne spécialisée dans la vente de sweatshirts. Il permet aux utilisateurs de parcourir une sélection de produits promus, de les ajouter à leur panier et de finaliser leur achat grâce à la solution de paiement sécurisée **Stripe**.
Le projet se veut simple, intuitif et basé sur des technologies modernes. Il inclut l'intégration des APIs Stripe pour gérer les paiements en ligne de manière sécurisée.
### 1.3 Objectifs
- **Fonctionnel** :
    - Afficher une page d'accueil listant les produits principaux (promotions actuelles).
    - Gérer un processus d’achat avec un panier dynamique.
    - Réaliser des paiements sécurisés via **Stripe Checkout**.
    - Permettre une navigation facile pour l'utilisateur.

- **Technique** :
    - Suivre les meilleures pratiques de développement Symfony (règles PSR, SOLID, etc.).
    - Implémenter des tests unitaires avec PHPUnit pour garantir le fonctionnement des services(e.g., gestion des paiements).
    - Proposer une solution facilement déployable.

## **2. Environnement technique**
### Technologies utilisées :
- **Langage** : PHP 8.1+
- **Framework** : Symfony 6 (back-end).
- **Base de données** : MySQL 8.0.
- **Plateforme de paiement** : Stripe.
- **Client HTTP utilisé** : Symfony HTTP Client (ou cURL via Stripe SDK).
- **Serveur de développement** : Symfony CLI intégré.
- **Environnement de test** : PHPUnit.

### Pré-requis :
- Serveur : minimum PHP 8.1, MySQL.
- Logiciels nécessaires :
    - PHP 8.1 ou supérieur (+ extensions `pdo`, `mbstring`, `json`, `openssl`).
    - Composer (gestionnaire de dépendances PHP).
    - Un serveur MySQL (ou MariaDB).
    - Un serveur Web (Symfony CLI, Apache ou Nginx).

- Un compte Stripe (avec des clés de test disponibles).

## **3. Procédure d'installation**
Suivez ces étapes pour exécuter l'application sur votre environnement local.
### Étape 1 : Cloner le projet
Récupérez les fichiers du projet depuis le dépôt Git.
``` bash
git clone https://github.com/mondroit/depot-projet.git
cd depot-projet
```
### Étape 2 : Installer les dépendances
Utilisez Composer pour installer les dépendances PHP.
``` bash
composer install
```
### Étape 3 : Configurer l'application
Créez un fichier `.env.local` à partir du fichier `.env` et ajoutez vos paramètres personnalisés.
``` text
APP_ENV=dev
APP_SECRET=monsecretunique

DATABASE_URL="mysql://nom_utilisateur:mot_de_passe@127.0.0.1:3306/nom_base_de_donnees"

STRIPE_API_SECRET="sk_test_votre_clé_secrète"
STRIPE_API_PUBLIC="pk_test_votre_clé_publique"
```
### Étape 4 : Préparer la base de données
Lancez la commande pour créer et migrer les tables dans la base de données.
``` bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
### Étape 5 : Charger les fixtures
Chargez les données par défaut, incluant des produits.
``` bash
php bin/console doctrine:fixtures:load
```
### Étape 6 : Démarrer le serveur local
Lancez le serveur Symfony pour tester l'application.
``` bash
symfony server:start
```
L'application sera accessible sur : [https://127.0.0.1:8000]().
## **4. Fonctionnalités principales**
### Page d'accueil :
- Affiche une sélection de produits promus avec leur image, description et prix.

### Paiement avec Stripe :
- Le panier est validé via une redirection vers une page Stripe Checkout.
- Les clients peuvent simuler un paiement sécurisé via des clés de test Stripe.

### Simulation d'un paiement :
- Testez une transaction Stripe avec les éléments suivants :
    - **Carte de test** : `4242 4242 4242 4242`
    - **Date d'expiration** : Une date valide dans le futur (par ex., `12/34`).
    - **Code de sécurité (CVC)** : `123`.
 
### Procédure pour exécuter les tests avec PHPUnit
- Installer PHPUnit : Si PHPUnit n'est pas encore installé, utilisez Composer pour l'ajouter à votre projet :
``` bash
composer require --dev phpunit/phpunit
```
- Exécuter un fichier spécifique : Si vous souhaitez exécuter uniquement les tests du fichier (exemple: CartServiceTest.php), utilisez :
``` bash
./vendor/bin/phpunit tests/Service/CartServiceTest.php
```
