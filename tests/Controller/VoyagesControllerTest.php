<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesControllerTest
 *
 * @author Jadem
 */
class VoyagesControllerTest extends WebTestCase
{
    private const VOYAGES_PATH = '/voyages';
    public function testAccesPage()
    {
        $client = static::createClient();
        $client->request('GET', self::VOYAGES_PATH);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testContenuPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::VOYAGES_PATH);
        $this->assertSelectorTextContains('h1', 'Mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Revel');
    }
    public function testLinkVille()
    {
        $client = static::createClient();
        $client->request('GET', self::VOYAGES_PATH);
        // clic sur un lien (le nom d'une ville)
        $client->clickLink('Revel');
        // récupération du résultat du clic
        $response = $client->getResponse();
        dd($client->getRequest());
        // contrôle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle qu'elle est correct
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/101', $uri);
    }
    public function testFiltreVille()
    {
        $client = static::createClient();
        $client->request('GET', '/voyages');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Revel'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la ville correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Revel');
    }
}
