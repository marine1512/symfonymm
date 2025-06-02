# Documentation de la classe `App\Entity\Sweatshirt`

## Classe
- **Résumé :** Représente un Sweatshirt avec ses propriétés basiques.

## Propriétés
- **$id**
  - **Résumé :** Identifiant unique du Sweatshirt.

- **$name**
  - **Résumé :** Nom du Sweatshirt.

- **$price**
  - **Résumé :** Prix du Sweatshirt en euros.

- **$isPromoted**
  - **Résumé :** Indique si le Sweatshirt est en promotion.

- **$stockBySize**
  - **Résumé :** Stock du Sweatshirt par taille (ex: ['S' => 10, 'M' => 5]).

- **$image**
  - **Résumé :** URL ou chemin local de l'image du Sweatshirt.

## Méthodes
- **getId()**
  - **Résumé :** Retourne l'identifiant (ID) du Sweatshirt.
  - **Retourne :** int

- **getName()**
  - **Résumé :** Retourne le nom du Sweatshirt.
  - **Retourne :** string

- **setName()**
  - **Résumé :** Définit le nom du Sweatshirt.
  - **Paramètres :**
    - $name : string
  - **Retourne :** self

- **getPrice()**
  - **Résumé :** Retourne le prix du Sweatshirt.
  - **Retourne :** float

- **setPrice()**
  - **Résumé :** Définit le prix du Sweatshirt.
  - **Paramètres :**
    - $price : float
  - **Retourne :** self

- **getIsPromoted()**
  - **Résumé :** Indique si le Sweatshirt est en promotion.
  - **Retourne :** bool

- **setIsPromoted()**
  - **Résumé :** Définit si le Sweatshirt est en promotion.
  - **Paramètres :**
    - $isPromoted : bool
  - **Retourne :** self

- **getStockBySize()**
  - **Résumé :** Retourne le stock du Sweatshirt par taille.
  - **Retourne :** array

- **setStockBySize()**
  - **Résumé :** Définit le stock du Sweatshirt par taille.
  - **Paramètres :**
    - $stockBySize : array
  - **Retourne :** self

- **getImage()**
  - **Résumé :** Retourne l'image associée au Sweatshirt.
  - **Retourne :** string

- **setImage()**
  - **Résumé :** Définit l'image associée au Sweatshirt.
  - **Paramètres :**
    - $image : string
  - **Retourne :** self

