<?php

namespace App\Tests\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShopControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Démarrage du client pour les tests HTTP
        $this->client = static::createClient();

        // Récupérer le gestionnaire d'entités pour manipuler la base de données
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Utiliser SchemaTool pour recréer le schéma de la base
        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            // Supprime l'ancien schéma
            $schemaTool->dropSchema($metadata);

            // Crée le schéma actuel
            $schemaTool->createSchema($metadata);
        }

        // Charger les fixtures pour remplir la base de données avec des données de test
        $loader = new \Doctrine\Common\DataFixtures\Loader();
        $loader->addFixture(new \App\DataFixtures\SweatshirtFixtures());
        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($entityManager);
        $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testIndex(): void
    {
        // Utilisez le client initialisé dans setUp()
        $this->client->request('GET', '/products');

        // Vérifiez que la réponse est réussie (statut 200)
        self::assertResponseIsSuccessful();

        // Ajoutez une assertion pour vérifier l'affichage d'un produit
        self::assertSelectorExists('.product-card'); // Vérifie une carte produit
    }
}
