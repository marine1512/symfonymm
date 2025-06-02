# Documentation des routes pour le contrôleur `App\Controller\SweatshirtController`

## Contrôleur
- **Résumé :** Contrôleur pour gérer les opérations CRUD sur les sweatshirts côté admin.

### `index`
- **Résumé :** Affiche la liste de tous les sweatshirts.
- **Route :** `/`
- **Nom :** `index`
- **Méthodes autorisées :** GET

### `new`
- **Résumé :** Crée un nouveau sweatshirt.
- **Route :** `/new`
- **Nom :** `new`
- **Méthodes autorisées :** GET, POST

### `show`
- **Résumé :** Affiche un sweatshirt donné.
- **Route :** `/{id}`
- **Nom :** `show`
- **Méthodes autorisées :** GET

### `edit`
- **Résumé :** Édite un sweatshirt donné.
- **Route :** `/{id}/edit`
- **Nom :** `edit`
- **Méthodes autorisées :** GET, POST

### `delete`
- **Résumé :** Supprime un sweatshirt donné.
- **Route :** `/{id}`
- **Nom :** `delete`
- **Méthodes autorisées :** POST

