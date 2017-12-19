<?php

namespace App\Action\Comments;

use App\Enum\HttpResponses;
use App\Model\Service\Comment\Comment;
use App\Model\Service\Comment\CommentService;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db;
use Zend\Diactoros\Response\JsonResponse;

class ListCommentsAction implements ServerMiddlewareInterface {

    private $dbAdapter;

    public function __construct(Db\Adapter\Adapter $adapter) {
        $this->dbAdapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) {
    
        $postService = new CommentService();
        $return = $postService->getComments($this->dbAdapter, $request->getQueryParams());
        
        return new JsonResponse((array) $return, HttpResponses::HTTP_OK, array('Access-Control-Allow-Origin' => '*'));
    }

}
