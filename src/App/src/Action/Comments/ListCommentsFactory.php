<?php

namespace App\Action\Comments;

use Interop\Container\ContainerInterface;

class ListCommentsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');

        return new ListCommentsAction($adapter);
    }
}
