# Documentation de la classe `App\Controller\HomeController`

## Classe
- **Résumé :** Contrôleur HomeController.
- **Description :** Ce contrôleur est responsable de la gestion de la route "/home",
incluant l'affichage des produits promus et la vérification de
l'état de connexion de l'utilisateur pour personnaliser la vue.

## Propriétés
- **$container**

## Méthodes
- **index()**
  - **Résumé :** Méthode principale du contrôleur qui affiche la page d'accueil.
  - **Description :** Cette méthode se charge de récupérer les produits promus
via le repository et de transmettre les données nécessaires
à la vue Twig associée.
  - **Paramètres :**
    - $sweatshirtRepository : App\Repository\SweatshirtRepository
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

