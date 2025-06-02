<?php

namespace App\Tests\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeControllerTest extends WebTestCase
{
    private $client; // Propriété correctement déclarée

    protected function setUp(): void
    {
        parent::setUp();

        // Initialisation du client
        $this->client = static::createClient();

        // Récupérer l'Entity Manager pour manipuler la base de données
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Utilisation de SchemaTool pour recréer le schéma
        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            // Supprimer l'ancien schéma
            $schemaTool->dropSchema($metadata);

            // Créer le nouveau schéma
            $schemaTool->createSchema($metadata);
        }

        // Charger les fixtures
        $loader = new \Doctrine\Common\DataFixtures\Loader();
        $loader->addFixture(new \App\DataFixtures\SweatshirtFixtures());
        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($entityManager);
        $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testIndex(): void
    {
        // Utilisation du client initialisé dans setUp()
        $this->client->request('GET', '/home');

        // Vérifiez que la réponse est réussie (status 200)
        self::assertResponseIsSuccessful();

        // Vous pouvez ajouter des assertions supplémentaires ici
        self::assertSelectorExists('.product-card'); // Existence d'un produit affiché
    }
}
