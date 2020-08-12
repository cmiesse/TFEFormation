<?php

namespace TIC\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TICUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
