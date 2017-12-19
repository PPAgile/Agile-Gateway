<?php

declare(strict_types = 1);

namespace App\Model\Service\Post;

use App\Enum\PostTypes;
use Zend\Db\Adapter\Adapter;

class PostStrategyContext {

    private $strategy = NULL;

    //bookList is not instantiated at construct time
    public function __construct($type) {
        switch ($type) {
            case PostTypes::article:
                $this->strategy = new ArticlePost();
                break;
            default :
                throw new Exception('Unknown post strategy');
        }
    }

    public function createPost(Adapter $adapter, $data) {
        return $this->strategy->create($adapter, $data);
    }
    public function loadPost(Adapter $adapter, $id) {
        return $this->strategy->load($adapter, $id);
    }
}
