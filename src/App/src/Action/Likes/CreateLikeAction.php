<?php

namespace App\Action\Likes;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db;
use Zend\Json\Json;
use App\Model\Service\Post\PostService;

class CreateLikeAction implements ServerMiddlewareInterface
{
    private $dbAdapter;

    public function __construct(Db\Adapter\Adapter $adapter)
    {
        $this->dbAdapter = $adapter;
    }
    
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $idPost = Json::decode($request->getBody()->getContents())->idPost;
        $service = new PostService();
        $return = $service->addLike($this->dbAdapter, (int) $idPost);

        return new JsonResponse($return, 200, array('Access-Control-Allow-Origin' => '*'));
    }
}
