<?php

namespace App\Tests\Controller;

use App\Entity\Sweatshirt;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SweatshirtControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $sweatshirtRepository;
    private string $path = '/admin/';

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
    
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->manager);
        $metadata = $this->manager->getMetadataFactory()->getAllMetadata();
    
        if (!empty($metadata)) {
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    
        // Création d'un utilisateur administrateur pour les tests
        $user = new \App\Entity\User();
        $user->setUsername('test');
        $user->setEmail('test_admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(password_hash('admin', PASSWORD_BCRYPT)); // Encrypt le mot de passe
        $this->manager->persist($user);
        $this->manager->flush();

        // Ajout de plusieurs sweatshirts pour les tests
        $sweatshirt1 = new Sweatshirt();
        $sweatshirt1->setName('Sweatshirt Rouge');
        $sweatshirt1->setPrice(29.99);
        $sweatshirt1->setIsPromoted(true);
        $sweatshirt1->setStockBySize(['S' => 10, 'M' => 5, 'L' => 3]);
        $sweatshirt1->setImage('path/to/image1.jpg');
        $this->manager->persist($sweatshirt1);

        $sweatshirt2 = new Sweatshirt();
        $sweatshirt2->setName('Sweatshirt Bleu');
        $sweatshirt2->setPrice(34.99);
        $sweatshirt2->setIsPromoted(false);
        $sweatshirt2->setStockBySize(['S' => 8, 'M' => 4, 'L' => 2]);
        $sweatshirt2->setImage('path/to/image2.jpg');
        $this->manager->persist($sweatshirt2);

        $this->manager->flush();
    
        // Connecter cet utilisateur
        $this->client->loginUser($user);
    }

public function testIndex(): void
{
    // Assurez-vous que les redirections sont suivies
    $this->client->followRedirects();

    // Faire une requête pour accéder à la page admin
    $crawler = $this->client->request('GET', $this->path);

    // Vérifiez que la réponse réussit (code HTTP 200)
    self::assertResponseIsSuccessful();

    // Vérifiez que le titre de la page contient "Sweatshirt index"
    self::assertPageTitleContains('Sweatshirt');
}

public function testNew(): void
{
    // Accédez à la page "Créer un sweatshirt"
    $this->client->request('GET', sprintf('%snew', $this->path));

    // Vérifiez que la page est servie correctement (HTTP 200)
    self::assertResponseStatusCodeSame(200);

    // Soumettez le formulaire de création
    $this->client->submitForm('Ajouter', [
        'sweatshirt[name]' => 'Sweatshirt de Test',
        'sweatshirt[price]' => 19.99,
        'sweatshirt[isPromoted]' => true,
        'sweatshirt[image]' => 'path/to/test-image.jpg',
    ]);

    // Vérifiez la redirection après sauvegarde réussie
    self::assertResponseRedirects($this->path);

    // Vérifiez que l'objet a bien été créé en base
    $sweatshirts = $this->manager->getRepository(Sweatshirt::class)->findAll();
    self::assertCount(1, $sweatshirts);

    $sweatshirt = $sweatshirts[0];
    self::assertSame('Sweatshirt de Test', $sweatshirt->getName());
    self::assertSame(19.99, $sweatshirt->getPrice());
    self::assertTrue($sweatshirt->getIsPromoted());
    self::assertSame('path/to/test-image.jpg', $sweatshirt->getImage());
}

public function testShow(): void
{
    // Créez un sweatshirt pour le test
    $fixture = new Sweatshirt();
    $fixture->setName('Sweatshirt Test');
    $fixture->setPrice(29.99);
    $fixture->setIsPromoted(false);

    $this->manager->persist($fixture);
    $this->manager->flush();

    // Accédez à la page de détails du sweatshirt
    $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    // Vérifiez que la page a été servie correctement
    self::assertResponseStatusCodeSame(200);

    // Vérifiez que les informations du sweatshirt sont affichées correctement
    self::assertPageTitleContains('Sweatshirt');
    self::assertSelectorTextContains('h1', $fixture->getName());
    self::assertSelectorTextContains('.product-price', '29.99 €'); // Adaptez à votre template
}

public function testEdit(): void
{
    // Créez un sweatshirt pour le test
    $fixture = new Sweatshirt();
    $fixture->setName('Old Name');
    $fixture->setPrice(29.99);
    $fixture->setIsPromoted(false);

    $this->manager->persist($fixture);
    $this->manager->flush();

    // Accédez à la page d'édition
    $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    // Soumettez le formulaire avec de nouvelles données
    $this->client->submitForm('Enregistrer', [
        'name' => 'New Name',
        'price' => 49.99,
        'isPromoted' => true,
    ]);

    // Vérifiez la redirection après sauvegarde
    self::assertResponseRedirects($this->path);

    // Rechargez l'entité en base
    $sweatshirt = $this->manager->getRepository(Sweatshirt::class)->find($fixture->getId());

    // Vérifiez que le sweatshirt a bien été mis à jour
    self::assertSame('New Name', $sweatshirt->getName());
    self::assertSame(49.99, $sweatshirt->getPrice());
    self::assertTrue($sweatshirt->getIsPromoted());
}

public function testRemove(): void
{
    // Créez un sweatshirt pour le test
    $fixture = new Sweatshirt();
    $fixture->setName('Sweatshirt To Delete');
    $fixture->setPrice(19.99);
    $fixture->setIsPromoted(false);

    $this->manager->persist($fixture);
    $this->manager->flush();

    // Accédez à la page du sweatshirt, puis supprimez-le
    $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    $this->client->submitForm('Supprimer');

    // Vérifiez la redirection après suppression
    self::assertResponseRedirects($this->path);

    // Vérifiez que le sweatshirt a été supprimé
    self::assertSame(0, $this->manager->getRepository(Sweatshirt::class)->count([]));
}
}
