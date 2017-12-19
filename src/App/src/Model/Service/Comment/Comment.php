<?php

declare(strict_types = 1);

namespace App\Model\Service\Comment;

use Zend\Json\Json;
use Zend\Db\Adapter\Adapter;
use Zend\Uri\Http;
use App\Model\Entity\{
    Comment AS commentEntity,
    AuthorComment,
    Post,
    Author
};
use App\Model\Db\{
    AuthorCommentTable,
    CommentTable,
    PostTable,
    PostArticleTable,
    AuthorTable
};
use \App\Enum\PostTypes;

class Comment {

    public $id;
    public $comment;
    public $author;
    public $post;
    public $dateCreated;

    public function __construct() {
        ;
    }

    public function load(Adapter $adapter, $id) {
        //load comment by id
        $comment = $this->_loadComment($adapter, (int) $id);
        //load post information to comment
        $post = $this->_loadPost($adapter, (int) $comment->getIdPost());
        //load author of comment
        $this->_loadAuthor($adapter, (int) $comment->getIdAuthorComment());

        return $this;
    }

    public function create(Adapter $adapter, $data) {
        $data = $this->_validate($data);

        try {
            //begin transaction
            $adapter->getDriver()->getConnection()->beginTransaction();

            if ($this->_postExists($adapter, $data->idPost)) {
                //check if author exists, if not create new author
                $this->_createAuthor($adapter, $data->author);
                //createComment
                $this->_createComment($adapter, $data);
            }

            //commit
            $adapter->getDriver()->getConnection()->commit();
        } catch (\Exception $e) {
            //rollback
            $adapter->getDriver()->getConnection()->rollback();
            throw $e;
        }
        return $this;
    }

    protected function _validate($data) {
        $decoded = Json::decode($data);
        return $decoded;
    }

    protected function _loadComment($adapter, $id) {
        $table = new CommentTable($adapter);
        $comment = $table->getById($id);

        $this->setId($id);
        $this->setComment($comment->getComment());
        $this->setDateCreated((new \DateTime($comment->getDateCreated()))->format("Y-m-d\TH:i:s"));
        
        return $comment;
    }

    protected function _loadPost($adapter, $id) {
        $resultPost = null;
        $table = new PostTable($adapter);
        $resultPost = $table->getById($id);

        $table = new PostArticleTable($adapter);
        $articlePost = $table->getByIdPost($id);

        $resultPost->readLength = $articlePost->getReadLength();
        $resultPost->id_post_article = $articlePost->getId();

        $this->setPost($resultPost);

        return $resultPost;
    }

    protected function _loadAuthor($adapter, $id) {
        $table = new AuthorCommentTable($adapter);
        $authorComment = $table->getById($id);
        $table = new AuthorTable($adapter);
        $author = $table->getById((int) $authorComment->getIdAuthor());

        $authorComment->name = $author->GetName();
        $this->setAuthor($authorComment);

        return $authorComment;
    }

    protected function _createAuthor(Adapter $adapter, $authorName) {
        $table = new AuthorTable($adapter);
        $author = $table->getByName($authorName);

        if (is_null($author)) {
            $author = (new Author())->setName($authorName);
            $table->save($author);
        }

        $table = new AuthorCommentTable($adapter);
        $authorComment = $table->getByIdAuthor((int) $author->getId());
        if (is_null($authorComment)) {
            $authorComment = (new AuthorComment())->setIdAuthor($author->getId());
            $table->save($authorComment);
        }
        $authorComment->name = $author->getName();
        $this->setAuthor($authorComment);
        return $authorComment;
    }

    protected function _postExists($adapter, $idPost) {
        $table = new PostTable($adapter);
        $post = $table->getById((int) $idPost);
        $this->setPost($post);

        return !is_null($post);
    }

    protected function _createComment($adapter, $data) {
        $table = new CommentTable($adapter);
        $comment = (new commentEntity())
                ->setComment($data->comment)
                ->setIdAuthorComment($this->getAuthor()->getId())
                ->setIdPost($this->getPost()->getId())
                ->setDateCreated((new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->format("Y-m-d\TH:i:s"));

        $table->save($comment);

        $this->setId($comment->getId());
        $this->setComment($comment->getComment());
        $this->setDateCreated($comment->getDateCreated());

        return $comment;
    }

    public function getId() {
        return $this->id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getPost() {
        return $this->post;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function setPost($post) {
        $this->post = $post;
        return $this;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
        return $this;
    }


}
