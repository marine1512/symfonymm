# Documentation de la classe `App\Service\StripeService`

## Classe
- **Résumé :** Service pour l'intégration avec l'API Stripe.
- **Description :** Cette classe permet de gérer les interactions avec Stripe,
y compris la création de sessions de paiement.

## Propriétés
- **$stripeApiSecret**

## Méthodes
- **createCheckoutSession()**
  - **Résumé :** Crée une session Stripe Checkout.
  - **Description :** Cette méthode construit les `line_items` à partir des éléments du panier
et génère une session de paiement Stripe.
  - **Paramètres :**
    - $cartItems : array
    - $successUrl : string
    - $cancelUrl : string
  - **Retourne :** Stripe\Checkout\Session

