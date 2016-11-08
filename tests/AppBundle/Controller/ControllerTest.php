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
            array('/wynik-losowania'),  //tutaj sie wyjebuje na plecy
            array('/akceptuj-przepisy'),
            array('/panel-admina'),
            array('/fos_user_security_login'),  //od tego momentu również
            array('/fos_user_security_check'),
            array('/fos_user_security_logout'),
            array('/fos_user_profile_show'),
            array('/fos_user_profile_edit'),
            array('/fos_user_registration_register'),
            array('/fos_user_registration_check_email'),
            array('/fos_user_registration_confirm'),
            array('/fos_user_registration_confirmed'),
            array('/fos_user_resetting_request'),
            array('/fos_user_resetting_send_email'),
            array('/fos_user_resetting_check_email'),
            array('/fos_user_resetting_reset'),
            array('/fos_user_change_password'),

        );
    }
}
