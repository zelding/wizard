<?php

namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = self::createClient();

        $crawler = $client->request('POST', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //$this->assertContains('test_text', $crawler->filter('#test_div'));
    }
}
