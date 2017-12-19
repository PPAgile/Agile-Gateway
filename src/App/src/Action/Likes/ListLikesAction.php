<?php

namespace App\Action\Likes;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\Author;
use App\Model\Db\AuthorTable;

class ListLikesAction implements ServerMiddlewareInterface {

    private $dbAdapter;

    public function __construct(Db\Adapter\Adapter $adapter) {
        $this->dbAdapter = $adapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) {
           
        $table = new AuthorTable($this->dbAdapter);
        $author = $table->getById(1);
        var_dump($author);
        /*
        $author->setName('tetetet');
        $table->save($author);*/
        
        $author = new Author();
        $author->setName('novy');
        $tbl = new AuthorTable($this->dbAdapter);
        $tbl->save($author);
        var_dump($author);/*
        $author->setName('change');
        $tbl->save($author);
        var_dump($author);*/
        /*$result->setName('marta');
        $table->saveAuthor($result);
        
        $result = $table->getAuthor(1);*/
        //var_dump($result);*/
        
        /*$table = new AuthorTable($this->dbAdapter);
        $table->delete($table->getById(3));*/
        return new JsonResponse(1, 200, array('Access-Control-Allow-Origin' => '*'));
    }

}
