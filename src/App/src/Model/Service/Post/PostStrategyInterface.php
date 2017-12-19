<?php
namespace App\Model\Service\Post;

use Zend\Db\Adapter\Adapter;

interface PostStrategyInterface {
    public function create(Adapter $adapter, $data);
}

