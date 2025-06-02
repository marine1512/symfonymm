# Documentation de la classe `App\Entity\User`

## Classe :
- **Résumé :** Entité représentant un utilisateur.
- **Description :** 

## Propriétés :
- **id**
  - **Résumé :** ID unique de l'utilisateur.

- **username**
  - **Résumé :** Nom d'utilisateur unique.

- **email**
  - **Résumé :** Adresse e-mail unique de l'utilisateur.

- **shippingAddress**
  - **Résumé :** Adresse de livraison.

- **roles**
  - **Résumé :** Rôles associés à l'utilisateur (format JSON).

- **password**
  - **Résumé :** Mot de passe chiffré de l'utilisateur.

- **isVerified**
  - **Résumé :** Indique si l'utilisateur est vérifié.

- **emailVerificationToken**
  - **Résumé :** Jeton pour la vérification de l'adresse e-mail.

## Méthodes :
- **getId()**
  - **Résumé :** Retourne l'ID de l'utilisateur.

- **getUserIdentifier()**
  - **Résumé :** Retourne l'identifiant unique de l'utilisateur (adresse e-mail).

- **getUsername()**
  - **Résumé :** Retourne le nom d'utilisateur.

- **setUsername()**
  - **Résumé :** Définit le nom d'utilisateur.

- **getEmail()**
  - **Résumé :** Récupère l'adresse e-mail.

- **setEmail()**
  - **Résumé :** Définit l'adresse e-mail.

- **getShippingAddress()**
  - **Résumé :** Retourne l'adresse de livraison.

- **setShippingAddress()**
  - **Résumé :** Définit l'adresse de livraison.

- **getRoles()**
  - **Résumé :** Retourne les rôles associés à l'utilisateur.

- **setRoles()**
  - **Résumé :** Définit les rôles de l'utilisateur.

- **getPassword()**
  - **Résumé :** Retourne le mot de passe chiffré.

- **setPassword()**
  - **Résumé :** Définit le mot de passe.

- **eraseCredentials()**
  - **Résumé :** Efface les informations sensibles.

- **isVerified()**
  - **Résumé :** Indique si l'utilisateur est vérifié.

- **setIsVerified()**
  - **Résumé :** Définit si l'utilisateur est vérifié.

- **getEmailVerificationToken()**
  - **Résumé :** Retourne le jeton de vérification de l'e-mail.

- **setEmailVerificationToken()**
  - **Résumé :** Définit le jeton de vérification de l'e-mail.

