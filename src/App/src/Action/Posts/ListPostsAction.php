<?php
namespace App\Action\Posts;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db;


use App\Model\Service\Post\PostService;
use App\Enum\HttpResponses;

class ListPostsAction implements ServerMiddlewareInterface {

    private $dbAdapter;

    public function __construct(Db\Adapter\Adapter $adapter) {
        $this->dbAdapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) {
        /*$articles = require 'data.php';
        
        foreach ($articles as $article) {
            $postService = new PostService();
            //var_dump(json_encode((array) $article));
            $postService->createPost($this->dbAdapter, json_encode((array) $article));
        }*/
        
        $postService = new PostService();
        $return = $postService->getPosts($this->dbAdapter, $request->getQueryParams());
        return new JsonResponse((array) $return, HttpResponses::HTTP_OK, array('Access-Control-Allow-Origin' => '*'));
    }

}
