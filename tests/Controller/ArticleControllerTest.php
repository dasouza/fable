<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{

    public function testArticleHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/articulos/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertGreaterThan(1, $crawler->filter('article')->count());
    }

    public function testArticleIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/articulos/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertGreaterThan(1, $crawler->filter('article')->count());
    }

    public function testArticleShow()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/articulos/first-article');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('article')->count());
    }
}
