<?php

namespace App\Action\Likes;

use Interop\Container\ContainerInterface;

class CreateLikeFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');

        return new CreateLikeAction($adapter);
    }
}
