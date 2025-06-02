# Documentation de la classe `App\Controller\CartController`

## Classe
- **Résumé :** Contrôleur pour la gestion du panier et du processus d'achat.
- **Description :** 

## Propriétés
- **$container**

## Méthodes
- **index()**
  - **Résumé :** Affiche le contenu du panier avec le prix total.
  - **Paramètres :**
    * $request : Symfony\Component\HttpFoundation\Request
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **addToCart()**
  - **Résumé :** Ajoute un produit au panier.
  - **Paramètres :**
    * $id : mixed
    * $request : Symfony\Component\HttpFoundation\Request
    * $doctrine : Doctrine\Persistence\ManagerRegistry
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **removeFromCart()**
  - **Résumé :** Supprime un produit du panier.
  - **Paramètres :**
    * $id : mixed
    * $request : Symfony\Component\HttpFoundation\Request
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **checkout()**
  - **Résumé :** Lance le processus de paiement via Stripe.
  - **Paramètres :**
    * $cartService : App\Service\CartService
    * $stripeService : App\Service\StripeService
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **success()**
  - **Résumé :** Page de succès après paiement.
  - **Paramètres :**
    * $cartService : App\Service\CartService
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **cancel()**
  - **Résumé :** Page affichée en cas d'annulation du paiement.
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

