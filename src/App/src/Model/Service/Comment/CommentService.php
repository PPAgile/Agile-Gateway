<?php

declare(strict_types = 1);

namespace App\Model\Service\Comment;

use App\Enum\PostTypes;
use App\Model\Db\CommentTable;
use Zend\Db\Adapter\Adapter;
use Zend\Json\Json;

class CommentService {

    public function createComment(Adapter $adapter, $data = null) {

        try {
            $comment = new Comment();
            $data = $comment->create($adapter, $data);
        } catch (Exception $e) {
            throw $e;
        }
        return $data;
    }

    public function getComments(Adapter $adapter, array $queryParams) {
        $return = array();

        //get all comments
        $table = new CommentTable($adapter);
        $comments = (array) $table->fetchAll();

        //load info about comment and its relations
        foreach ($comments as $comment) {
            $commentDetail = $this->_getComment($adapter, (int) $comment->getId());
            $return[$commentDetail->post->id_post][] = $commentDetail;
        }

        return $return;
    }

    protected function _getComment($adapter, int $id) {
        $comment = new Comment();

        return $comment->load($adapter, $id);
    }

}
