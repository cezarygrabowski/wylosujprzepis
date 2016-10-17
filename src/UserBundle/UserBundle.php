<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    //TO FOSUserBundle (enables overriding layout.html.twig)
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
