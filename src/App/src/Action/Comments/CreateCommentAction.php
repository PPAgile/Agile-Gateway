<?php

namespace App\Action\Comments;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db;
use Zend\Json\Json;
use App\Enum\HttpResponses;

use App\Model\Service\Comment\CommentService;

class CreateCommentAction implements ServerMiddlewareInterface {

    private $dbAdapter;

    public function __construct(Db\Adapter\Adapter $adapter) {
        $this->dbAdapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) {
        $commentService = new CommentService();
        $return = $commentService->createComment($this->dbAdapter, $request->getBody()->getContents());
        
        return new JsonResponse((array) $return, HttpResponses::HTTP_OK, array('Access-Control-Allow-Origin' => '*'));
    }

}
