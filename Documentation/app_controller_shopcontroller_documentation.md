# Documentation de la classe `App\Controller\ShopController`

## Classe
- **Résumé :** Contrôleur pour gérer la boutique en ligne.
- **Description :** Ce contrôleur gère la liste des produits et les détails d'un produit individuel.

## Propriétés
- **$container**

## Méthodes
- **list()**
  - **Résumé :** Affiche la liste des produits disponibles dans la boutique.
  - **Description :** Cette méthode applique un filtrage facultatif basé sur une plage de prix
indiquée dans les requêtes.
  - **Paramètres :**
    - $request : Symfony\Component\HttpFoundation\Request
    - $productRepository : App\Repository\SweatshirtRepository
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **detail()**
  - **Résumé :** Affiche les détails d'un produit spécifique.
  - **Description :** Si le produit n'est pas trouvé, une exception HTTP 404 est levée.
  - **Paramètres :**
    - $id : int
    - $productRepository : App\Repository\SweatshirtRepository
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

