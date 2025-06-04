
Repository : https://github.com/marine1512/symfonymm

Documentation du Projet : Plateforme E-Commerce de Sweatshirts

Ce projet propose une boutique en ligne spécialisée dans la vente de sweatshirts. Il permet aux utilisateurs de parcourir une sélection de produits, de les ajouter à leur panier et de finaliser leur achat grâce à la solution de paiement sécurisée : Stripe.
Le projet se veut simple, intuitif et basé sur des technologies modernes. Il inclut l'intégration des APIs Stripe pour gérer les paiements en ligne de manière sécurisée.

Objectifs : 
    - Permettre une navigation facile pour l'utilisateur connecté.
    - Afficher une page d'accueil listant les produits principaux.
    - Gérer un processus d’achat avec un panier dynamique.
    - Réaliser des paiements sécurisés via **Stripe Checkout**.

Fonctionnalités

Connexion et Inscription :
- Permet à l'utilisateur de se connecter et de s'inscrire si il ne se trouve pas dans la basee de données.

Page d'accueil :
- Affiche une sélection de produits promus avec leur image, description et prix.

Page Boutique :
- Affiche l'ensemble des sweatshirts avec possibilité de les filtrer par prix.

Paiement avec Stripe :
- Le panier est validé via une redirection vers une page Stripe Checkout.
- Les clients peuvent simuler un paiement sécurisé via des clés de test Stripe.

Technologies utilisées :
- **Langage** : PHP 8.1+
- **Framework** : Symfony 6 
- **Base de données** : MySQL 8.0
- **Plateforme de paiement** : Stripe
- **Serveur de développement** : Symfony CLI intégré
- **Environnement de test** : PHPUnit

Procédure d'installation

-	 Cloner le projet
Récupérez les fichiers du projet depuis le dépôt Git.
``` bash
git clone https://github.com/mondroit/depot-projet.git
cd depot-projet
```

-	Installer les dépendances
Utilisez Composer pour installer les dépendances PHP.
``` bash
composer install
```

-	Configurer l'application
Créez un fichier `.env.local` à partir du fichier `.env` et ajoutez vos paramètres personnalisés.
``` text
APP_ENV=dev
APP_SECRET=

DATABASE_URL="mysql://nom_utilisateur:mot_de_passe@127.0.0.1:3306/nom_base_de_donnees"

STRIPE_API_SECRET="sk_test_votre_clé_secrète"
STRIPE_API_PUBLIC="pk_test_votre_clé_publique"
```

-	Préparer la base de données
Lancez la commande pour créer et migrer les tables dans la base de données.
``` bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

-	Charger les fixtures
Chargez les données par défaut, incluant des produits.
``` bash
php bin/console doctrine:fixtures:load
```

-	 Démarrer le serveur local
Lancez le serveur Symfony pour tester l'application.
``` bash
symfony server:start
```

L'application sera accessible sur : https://127.0.0.1:8000.

______________________

- Testez une transaction Stripe avec les éléments suivants :
    - **Carte de test** : `4242 4242 4242 4242`
    - **Date d'expiration** : par ex: `12/34`.
    - **Code de sécurité (CVC)** : `123`.

STRIPE_SECRET_KEY=***REMOVED***tdXcoroX0WZSnXmLOLJn3uTfEyRXxYELbZ3f5OcNUZ2E5y3FI304Qupc4z1GIPWp900Htq0nD74
STRIPE_PUBLIC_KEY=pk_test_51ROfCc2a6UM81evrHoC8F4lK7B2oqFe8BqNWGJFItsfYUHCeMyr9YAyAjAlrHMaMs0SdKDUHboY2BUwGvnhGJIuL00vEslhlrs

- Procédure pour exécuter les tests avec PHPUnit
- Installer PHPUnit : Si PHPUnit n'est pas encore installé, utilisez Composer pour l'ajouter à votre projet :
``` bash
composer require --dev phpunit/phpunit
```
- Exécuter un fichier spécifique : Si vous souhaitez exécuter uniquement les tests du fichier (exemple: CartServiceTest.php), utilisez :
``` bash
./vendor/bin/phpunit tests/Service/CartServiceTest.php
```