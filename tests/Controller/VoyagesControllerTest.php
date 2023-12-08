<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesControllerTest
 *
 * @author Doryan
 */
class VoyagesControllerTest extends WebTestCase {
    
    public function testAccessPage(){
        $client = static::createClient();
        $client->request("GET", "/voyages");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
       
    }
    public function testContenuPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes Voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'New York');
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        dd($client->getRequest());
        //click sur un lien (le nom d'une ville)
        $client->clickLink('New York');
        //recuperation du resultat
        $response = $client->getResponse();
        //controle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        //recuperation de la route et controle si elle est correcte
        $uri= $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/voyages/voyage/105', $uri);
    }
    
    public function testFiltreVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        //simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'New York'
        ]);
        //verifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        //verifier si la ville correspond à la recherche
        $this->assertSelectorTextContains('h5', 'New York');
    }
}
