<?php

/**
 * Created by PhpStorm.
 * User: czaro
 * Date: 11.02.17
 * Time: 16:26
 */
class dodajPrzepisTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dodaj-przepis');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Śniadanie")')->count()
        );
    }
}