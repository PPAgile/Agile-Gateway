<?php

namespace App\Action\Posts;

use Interop\Container\ContainerInterface;

class ListPostsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');

        return new ListPostsAction($adapter);
    }
}
