<?php

require 'vendor/autoload.php';

use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\Routing\Annotation\Route as SymfonyRoute;
use ReflectionClass;
use ReflectionMethod;

/**
 * Génère la documentation d'une classe sous forme de fichier Markdown.
 *
 * @param string $className        Nom complet de la classe à documenter (avec namespace).
 * @param string $outputDirectory  Chemin du dossier où la documentation sera générée.
 */
function generateClassDocumentation(string $className, string $outputDirectory): void
{
    if (!class_exists($className)) {
        echo "Classe introuvable : {$className}\n";
        return;
    }

    $reflectionClass = new ReflectionClass($className);
    $docBlockFactory = DocBlockFactory::createInstance();

    // Initialisation du Markdown
    $documentation = "# Documentation de la classe `{$className}`\n\n";

    // Documentation de la classe
    if ($reflectionClass->getDocComment()) {
        $classDocBlock = $docBlockFactory->create($reflectionClass->getDocComment());
        $documentation .= "## Classe\n";
        $documentation .= "- **Résumé :** " . $classDocBlock->getSummary() . "\n";

        $description = $classDocBlock->getDescription()->render();
        if (!empty($description)) {
            $documentation .= "- **Description :** " . $description . "\n";
        }
        $documentation .= "\n";
    }

    // Documentation des propriétés
    $documentation .= "## Propriétés\n";
    foreach ($reflectionClass->getProperties() as $property) {
        $documentation .= "- **\${$property->getName()}**\n";
        if ($property->getDocComment()) {
            $propertyDocBlock = $docBlockFactory->create($property->getDocComment());
            $documentation .= "  - **Résumé :** " . $propertyDocBlock->getSummary() . "\n";
        }
        $documentation .= "\n";
    }

    // Documentation des méthodes publiques
    $documentation .= "## Méthodes\n";
    foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if ($method->isConstructor() || $method->isDestructor() || $method->isAbstract()) {
            continue;
        }

        $documentation .= "- **" . $method->getName() . "()**\n";

        if ($method->getDocComment()) {
            $methodDocBlock = $docBlockFactory->create($method->getDocComment());
            $documentation .= "  - **Résumé :** " . $methodDocBlock->getSummary() . "\n";

            $description = $methodDocBlock->getDescription()->render();
            if (!empty($description)) {
                $documentation .= "  - **Description :** " . $description . "\n";
            }

            // Documentation des paramètres
            $params = $method->getParameters();
            if (!empty($params)) {
                $documentation .= "  - **Paramètres :**\n";
                foreach ($params as $param) {
                    $type = $param->getType() ? $param->getType()->getName() : 'mixed';
                    $documentation .= "    - \${$param->getName()} : {$type}\n";
                }
            }

            // Retour de la méthode
            $returnType = $method->getReturnType();
            $documentation .= "  - **Retourne :** " . ($returnType ? $returnType->getName() : 'void') . "\n";
        }
        $documentation .= "\n";
    }

    // Enregistrement dans un fichier
    $fileName = strtolower(str_replace('\\', '_', $className)) . '_documentation.md';
    $filePath = "{$outputDirectory}/{$fileName}";
    file_put_contents($filePath, $documentation);
    echo "Documentation de la classe générée dans : {$filePath}\n";
}

/**
 * Génère la documentation des routes d'un contrôleur Symfony sous forme de fichier Markdown.
 *
 * @param string $controllerClass  Nom complet de la classe contrôleur à documenter.
 * @param string $outputDirectory  Chemin du dossier où la documentation sera générée.
 */
function generateControllerRoutesDocumentation(string $controllerClass, string $outputDirectory): void
{
    if (!class_exists($controllerClass)) {
        echo "Classe introuvable : {$controllerClass}\n";
        return;
    }

    $reflectionClass = new ReflectionClass($controllerClass);
    $docBlockFactory = DocBlockFactory::createInstance();

    // Initialisation du Markdown
    $documentation = "# Documentation des routes pour le contrôleur `{$controllerClass}`\n\n";

    // Documentation de la classe
    if ($reflectionClass->getDocComment()) {
        $classDocBlock = $docBlockFactory->create($reflectionClass->getDocComment());
        $documentation .= "## Contrôleur\n";
        $documentation .= "- **Résumé :** " . $classDocBlock->getSummary() . "\n";

        $description = $classDocBlock->getDescription()->render();
        if (!empty($description)) {
            $documentation .= "- **Description :** " . $description . "\n";
        }
        $documentation .= "\n";
    }

    // Documentation des méthodes et routes
    foreach ($reflectionClass->getMethods() as $method) {
        $routeAttributes = $method->getAttributes(SymfonyRoute::class);
        if (empty($routeAttributes)) {
            continue;
        }

        $documentation .= "### `" . $method->getName() . "`\n";

        if ($method->getDocComment()) {
            $methodDocBlock = $docBlockFactory->create($method->getDocComment());
            $documentation .= "- **Résumé :** " . $methodDocBlock->getSummary() . "\n";
        }

        foreach ($routeAttributes as $attribute) {
            /** @var SymfonyRoute $route */
            $route = $attribute->newInstance();
            $documentation .= "- **Route :** `" . $route->getPath() . "`\n";
            $documentation .= "- **Nom :** `" . $route->getName() . "`\n";
            $documentation .= "- **Méthodes autorisées :** " . implode(', ', $route->getMethods()) . "\n";
        }
        $documentation .= "\n";
    }

    // Enregistrement dans un fichier
    $fileName = strtolower(str_replace('\\', '_', $controllerClass)) . '_routes.md';
    $filePath = "{$outputDirectory}/{$fileName}";
    file_put_contents($filePath, $documentation);
    echo "Documentation des routes générée dans : {$filePath}\n";
}

// Création du dossier cible
$outputDirectory = __DIR__ . '/Documentation';
if (!is_dir($outputDirectory)) {
    mkdir($outputDirectory, 0777, true);
    echo "Dossier créé : {$outputDirectory}\n";
}

// Liste des classes à documenter
$classesToDocument = [
    'App\Controller\HomeController',
    'App\Controller\ShopController',
    'App\Controller\SweatshirtController',
    'App\Controller\UserController',
    'App\Entity\User',
    'App\Entity\Sweatshirt',
    'App\Service\CartService',
    'App\Service\StripeService'
];

foreach ($classesToDocument as $className) {
    generateClassDocumentation($className, $outputDirectory);
}

// Liste des contrôleurs pour documenter les routes
$controllersToDocumentRoutes = [
    'App\Controller\HomeController',
    'App\Controller\SweatshirtController',
    'App\Controller\ShopController',
    'App\Controller\UserController',

];

foreach ($controllersToDocumentRoutes as $controllerClass) {
    generateControllerRoutesDocumentation($controllerClass, $outputDirectory);
}