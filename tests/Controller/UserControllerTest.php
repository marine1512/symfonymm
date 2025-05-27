<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        // Faites une requête GET vers "/user"
        $crawler = $client->request('GET', '/user');

        // Vérifiez que la réponse HTTP est OK
        $this->assertResponseIsSuccessful();

        // Vérifiez qu'il y a un élément <h1> dans le HTML rendu
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }
}