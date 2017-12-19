<?php

namespace App\Action\Likes;

use Interop\Container\ContainerInterface;

class ListLikesFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');

        return new ListLikesAction($adapter);
    }
}
