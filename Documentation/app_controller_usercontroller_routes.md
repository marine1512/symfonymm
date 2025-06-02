# Documentation des routes pour le contrôleur `App\Controller\UserController`

## Contrôleur
- **Résumé :** Contrôleur pour gérer les utilisateurs.
- **Description :** Fournit des fonctionnalités pour créer des administrateurs
ou des utilisateurs ainsi que l'affichage des utilisateurs.

### `createUser`
- **Résumé :** Action pour créer un utilisateur administrateur.
- **Route :** `/create-admin`
- **Nom :** `create_admin`
- **Méthodes autorisées :** POST

### `createClient`
- **Résumé :** Action pour créer un utilisateur client.
- **Route :** `/create-client`
- **Nom :** `create_client`
- **Méthodes autorisées :** POST

### `index`
- **Résumé :** Action d'index pour afficher les utilisateurs.
- **Route :** `/user`
- **Nom :** `app_user_index`
- **Méthodes autorisées :** GET

