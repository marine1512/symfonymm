# Documentation de la classe `App\Service\CartService`

## Classe
- **Résumé :** Service pour gérer le panier de l'application.
- **Description :** Ce service offre des fonctionnalités pour ajouter, retirer,
vider le panier et consulter le contenu complet du panier.

## Propriétés
- **$requestStack**

- **$sweatshirtRepository**

## Méthodes
- **add()**
  - **Résumé :** Ajoute un produit au panier.
  - **Paramètres :**
    - $id : int
  - **Retourne :** void

- **getFullCart()**
  - **Résumé :** Récupère le contenu complet du panier avec les détails des produits.
  - **Retourne :** array

- **clear()**
  - **Résumé :** Vider complètement le panier.
  - **Retourne :** void

- **remove()**
  - **Résumé :** Retire un produit du panier.
  - **Paramètres :**
    - $id : int
  - **Retourne :** void

