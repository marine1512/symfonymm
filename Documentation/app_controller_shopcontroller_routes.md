# Documentation des routes pour le contrôleur `App\Controller\ShopController`

## Contrôleur
- **Résumé :** Contrôleur pour gérer la boutique en ligne.
- **Description :** Ce contrôleur gère la liste des produits et les détails d'un produit individuel.

### `list`
- **Résumé :** Affiche la liste des produits disponibles dans la boutique.
- **Route :** `/products`
- **Nom :** `shop`
- **Méthodes autorisées :** GET

### `detail`
- **Résumé :** Affiche les détails d'un produit spécifique.
- **Route :** `/product/{id}`
- **Nom :** `product_detail`
- **Méthodes autorisées :** GET

