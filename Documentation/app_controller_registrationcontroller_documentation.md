# Documentation de la classe `App\Controller\RegistrationController`

## Classe
- **Résumé :** Contrôleur de gestion des inscriptions et de la vérification des emails.
- **Description :** Ce contrôleur gère :
- L'inscription d'un nouvel utilisateur avec génération d'un token de vérification.
- La vérification de l'email de l'utilisateur via un lien unique.
- L'affichage de pages d'inscription et de confirmation.

## Propriétés
- **$emailVerifier**
  - **Résumé :** Service pour la vérification des emails.

- **$container**

## Méthodes
- **register()**
  - **Résumé :** Route pour l'inscription d'un nouvel utilisateur.
  - **Paramètres :**
    - $request : Symfony\Component\HttpFoundation\Request
    - $userPasswordHasher : Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface
    - $entityManager : Doctrine\ORM\EntityManagerInterface
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **verifyUserEmail()**
  - **Résumé :** Vérifie l'email de l'utilisateur en utilisant le token fourni dans l'URL.
  - **Paramètres :**
    - $request : Symfony\Component\HttpFoundation\Request
    - $entityManager : Doctrine\ORM\EntityManagerInterface
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **confirmEmailNotification()**
  - **Résumé :** Affiche une page de confirmation après l'inscription.
  - **Description :** Cette méthode est appelée après qu'un utilisateur ait soumis le formulaire d'inscription.
Elle affiche un message de succès et invite l'utilisateur à vérifier son email.
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

