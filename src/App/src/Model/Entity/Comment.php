<?php

namespace App\Model\Entity;

class Comment extends AbstractEntity {

    public $id_comment;
    public $comment;
    public $id_post;
    public $id_author_comment;
    public $date_created;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_comment');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_comment = $data['id_comment'] ?? null;
        $this->comment = $data['comment'] ?? null;
        $this->id_post = $data['id_post'] ?? null;
        $this->id_author_comment = $data['id_author_comment'] ?? null;
        $this->date_created = $data['date_created'] ?? null;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getIdPost() {
        return $this->id_post;
    }

    public function getIdAuthorComment() {
        return $this->id_author_comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }

    public function setIdPost($id_post) {
        $this->id_post = $id_post;
        return $this;
    }

    public function setIdAuthorComment($id_author_comment) {
        $this->id_author_comment = $id_author_comment;
        return $this;
    }
    
    public function getDateCreated() {
        return $this->date_created;
    }

    public function setDateCreated($date_created) {
        $this->date_created = $date_created;
        return $this;
    }


}
