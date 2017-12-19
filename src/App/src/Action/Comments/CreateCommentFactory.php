<?php

namespace App\Action\Comments;

use Interop\Container\ContainerInterface;

class CreateCommentFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('Zend\Db\Adapter\Adapter');

        return new CreateCommentAction($adapter);
    }
}
