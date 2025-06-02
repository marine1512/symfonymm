# Documentation de la classe `App\Entity\User`

## Classe
- **Résumé :** Entité représentant un utilisateur.

## Propriétés
- **$id**
  - **Résumé :** ID unique de l'utilisateur.

- **$username**
  - **Résumé :** Nom d'utilisateur unique.

- **$email**
  - **Résumé :** Adresse e-mail unique de l'utilisateur.

- **$shippingAddress**
  - **Résumé :** Adresse de livraison.

- **$roles**
  - **Résumé :** Rôles associés à l'utilisateur (format JSON).

- **$password**
  - **Résumé :** Mot de passe chiffré de l'utilisateur.

- **$isVerified**
  - **Résumé :** Indique si l'utilisateur est vérifié.

- **$emailVerificationToken**
  - **Résumé :** Jeton pour la vérification de l'adresse e-mail.

## Méthodes
- **getId()**
  - **Résumé :** Retourne l'ID de l'utilisateur.
  - **Retourne :** int

- **getUserIdentifier()**
  - **Résumé :** Retourne l'identifiant unique de l'utilisateur (adresse e-mail).
  - **Retourne :** string

- **getUsername()**
  - **Résumé :** Retourne le nom d'utilisateur.
  - **Retourne :** string

- **setUsername()**
  - **Résumé :** Définit le nom d'utilisateur.
  - **Paramètres :**
    - $username : string
  - **Retourne :** self

- **getEmail()**
  - **Résumé :** Récupère l'adresse e-mail.
  - **Retourne :** string

- **setEmail()**
  - **Résumé :** Définit l'adresse e-mail.
  - **Paramètres :**
    - $email : string
  - **Retourne :** self

- **getShippingAddress()**
  - **Résumé :** Retourne l'adresse de livraison.
  - **Retourne :** string

- **setShippingAddress()**
  - **Résumé :** Définit l'adresse de livraison.
  - **Paramètres :**
    - $shippingAddress : string
  - **Retourne :** self

- **getRoles()**
  - **Résumé :** Retourne les rôles associés à l'utilisateur.
  - **Retourne :** array

- **setRoles()**
  - **Résumé :** Définit les rôles de l'utilisateur.
  - **Paramètres :**
    - $roles : array
  - **Retourne :** self

- **getPassword()**
  - **Résumé :** Retourne le mot de passe chiffré.
  - **Retourne :** string

- **setPassword()**
  - **Résumé :** Définit le mot de passe.
  - **Paramètres :**
    - $password : string
  - **Retourne :** self

- **eraseCredentials()**
  - **Résumé :** Efface les informations sensibles.
  - **Retourne :** void

- **isVerified()**
  - **Résumé :** Indique si l'utilisateur est vérifié.
  - **Retourne :** bool

- **setIsVerified()**
  - **Résumé :** Définit si l'utilisateur est vérifié.
  - **Paramètres :**
    - $isVerified : bool
  - **Retourne :** self

- **getEmailVerificationToken()**
  - **Résumé :** Retourne le jeton de vérification de l'e-mail.
  - **Retourne :** string

- **setEmailVerificationToken()**
  - **Résumé :** Définit le jeton de vérification de l'e-mail.
  - **Paramètres :**
    - $emailVerificationToken : string
  - **Retourne :** self

