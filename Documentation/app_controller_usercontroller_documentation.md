# Documentation de la classe `App\Controller\UserController`

## Classe
- **Résumé :** Contrôleur pour gérer les utilisateurs.
- **Description :** Fournit des fonctionnalités pour créer des administrateurs
ou des utilisateurs ainsi que l'affichage des utilisateurs.

## Propriétés
- **$container**

## Méthodes
- **createUser()**
  - **Résumé :** Action pour créer un utilisateur administrateur.
  - **Description :** Cette méthode crée un utilisateur avec des rôles administrateurs et
le sauvegarde dans la base de données, si aucun administrateur n'existe déjà.
  - **Paramètres :**
    - $entityManager : Doctrine\ORM\EntityManagerInterface
    - $passwordHasher : Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface
  - **Retourne :** Symfony\Component\HttpFoundation\JsonResponse

- **createClient()**
  - **Résumé :** Action pour créer un utilisateur client.
  - **Description :** Cette méthode crée un utilisateur avec des rôles client et
le sauvegarde dans la base de données, si aucun utilisateur similaire n'existe déjà.
  - **Paramètres :**
    - $entityManager : Doctrine\ORM\EntityManagerInterface
    - $passwordHasher : Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface
  - **Retourne :** Symfony\Component\HttpFoundation\JsonResponse

- **index()**
  - **Résumé :** Action d'index pour afficher les utilisateurs.
  - **Description :** Cette méthode affiche les utilisateurs directement via un template Twig.
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

