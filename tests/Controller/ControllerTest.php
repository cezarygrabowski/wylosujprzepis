<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-06
 * Time: 23:08
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
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
            array('/deser'),
            array('/dodaj-przepis'),
            array('/dodaj-sniadanie'),
            array('/dodaj-obiad'),
            array('/dodaj-kolacje'),
            array('/dodaj-deser'),
            //array('/wynik-losowania'),
            //array('/akceptuj-przepisy'),
            array('/panel-admina'),
            array('/login'),
        );
    }
}
