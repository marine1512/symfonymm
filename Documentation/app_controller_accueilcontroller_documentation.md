# Documentation de la classe `App\Controller\AccueilController`

## Classe
- **Résumé :** Classe contrôleur pour gérer la page d'accueil.
- **Description :** Cette classe est responsable de l'affichage de la page d'accueil,
y compris la récupération des produits promus et la vérification
de l'état de connexion de l'utilisateur.

## Propriétés
- **$container**

## Méthodes
- **index()**
  - **Résumé :** Affiche la page d'accueil.
  - **Description :** Cette méthode récupère les produits promus via le repository
et vérifie si l'utilisateur est connecté avant d'envoyer les
données à un template Twig pour affichage.
  - **Paramètres :**
    - $sweatshirtRepository : App\Repository\SweatshirtRepository
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

