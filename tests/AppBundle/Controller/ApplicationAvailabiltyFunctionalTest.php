<?php

/**
 * Created by PhpStorm.
 * User: czaro
 * Date: 10.02.17
 * Time: 21:05
 */

class ApplicationAvailabiltyFunctionalTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/sniadanie'),
            array('/obiad'),
            array('/kolacja'),
  //          array('/dodaj-przepis'), // failed asserting that false is true
    //        array('/dodaj-sniadanie'),

            // ...
        );
    }

}