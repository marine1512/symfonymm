# Documentation de la classe `App\Controller\SecurityController`

## Classe
- **Résumé :** Contrôleur responsable de la gestion de la sécurité et des actions liées à l'authentification.

## Propriétés
- **$container**

## Méthodes
- **login()**
  - **Résumé :** Affiche la page de connexion et gère les erreurs d'authentification.
  - **Description :** Si l'utilisateur est déjà authentifié, il est redirigé vers la page d'accueil.
  - **Paramètres :**
    - $authenticationUtils : Symfony\Component\Security\Http\Authentication\AuthenticationUtils
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **loginCheck()**
  - **Résumé :** Gère le processus de validation des identifiants utilisateur.
  - **Description :** Cette méthode est interceptée automatiquement par Symfony pour gérer la connexion.
  - **Retourne :** void

- **logout()**
  - **Résumé :** Gère la déconnexion de l'utilisateur.
  - **Description :** Cette méthode est interceptée automatiquement par Symfony, et son contenu peut rester vide.
  - **Retourne :** void

- **setContainer()**

- **getSubscribedServices()**

