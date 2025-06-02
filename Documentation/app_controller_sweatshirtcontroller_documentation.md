# Documentation de la classe `App\Controller\SweatshirtController`

## Classe
- **Résumé :** Contrôleur pour gérer les opérations CRUD sur les sweatshirts côté admin.

## Propriétés
- **$container**

## Méthodes
- **index()**
  - **Résumé :** Affiche la liste de tous les sweatshirts.
  - **Paramètres :**
    - $sweatshirtRepository : App\Repository\SweatshirtRepository
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **new()**
  - **Résumé :** Crée un nouveau sweatshirt.
  - **Paramètres :**
    - $request : Symfony\Component\HttpFoundation\Request
    - $entityManager : Doctrine\ORM\EntityManagerInterface
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **show()**
  - **Résumé :** Affiche un sweatshirt donné.
  - **Paramètres :**
    - $sweatshirt : App\Entity\Sweatshirt
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **edit()**
  - **Résumé :** Édite un sweatshirt donné.
  - **Paramètres :**
    - $request : Symfony\Component\HttpFoundation\Request
    - $sweatshirt : App\Entity\Sweatshirt
    - $entityManager : Doctrine\ORM\EntityManagerInterface
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **delete()**
  - **Résumé :** Supprime un sweatshirt donné.
  - **Paramètres :**
    - $request : Symfony\Component\HttpFoundation\Request
    - $sweatshirt : App\Entity\Sweatshirt
    - $entityManager : Doctrine\ORM\EntityManagerInterface
  - **Retourne :** Symfony\Component\HttpFoundation\Response

- **setContainer()**

- **getSubscribedServices()**

