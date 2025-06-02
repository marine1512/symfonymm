<?php

namespace App\Tests\Controller;

use App\DataFixtures\SweatshirtFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccueilControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un client HTTP et démarrer le kernel
        $this->client = static::createClient();

        // Récupérer le gestionnaire d'entités via le container
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Rafraîchir la base de données
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        // Charger les fixtures
        $loader = new Loader();
        $loader->addFixture(new SweatshirtFixtures());

        $purger = new ORMPurger($entityManager);
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testIndex(): void
    {
        // Réutiliser le client initialisé dans `setUp()`
        $crawler = $this->client->request('GET', '/');

        // Vérifiez que la réponse HTTP est valide
        $this->assertResponseIsSuccessful();

        // Vérifiez que le contenu attendu est dans la page
        $this->assertSelectorTextContains('.product-card', 'Blackbelt 29.9 €');
    }
}