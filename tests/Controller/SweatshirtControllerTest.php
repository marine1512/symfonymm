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
    private string $path = '/sweatshirt/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->sweatshirtRepository = $this->manager->getRepository(Sweatshirt::class);

        foreach ($this->sweatshirtRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sweatshirt index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'sweatshirt[name]' => 'Testing',
            'sweatshirt[price]' => 'Testing',
            'sweatshirt[isPromoted]' => 'Testing',
            'sweatshirt[stockBySize]' => 'Testing',
            'sweatshirt[image]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->sweatshirtRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sweatshirt();
        $fixture->setName('My Title');
        $fixture->setPrice('My Title');
        $fixture->setIsPromoted('My Title');
        $fixture->setStockBySize('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sweatshirt');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sweatshirt();
        $fixture->setName('Value');
        $fixture->setPrice('Value');
        $fixture->setIsPromoted('Value');
        $fixture->setStockBySize('Value');
        $fixture->setImage('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'sweatshirt[name]' => 'Something New',
            'sweatshirt[price]' => 'Something New',
            'sweatshirt[isPromoted]' => 'Something New',
            'sweatshirt[stockBySize]' => 'Something New',
            'sweatshirt[image]' => 'Something New',
        ]);

        self::assertResponseRedirects('/sweatshirt/');

        $fixture = $this->sweatshirtRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getIsPromoted());
        self::assertSame('Something New', $fixture[0]->getStockBySize());
        self::assertSame('Something New', $fixture[0]->getImage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sweatshirt();
        $fixture->setName('Value');
        $fixture->setPrice('Value');
        $fixture->setIsPromoted('Value');
        $fixture->setStockBySize('Value');
        $fixture->setImage('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/sweatshirt/');
        self::assertSame(0, $this->sweatshirtRepository->count([]));
    }
}
