<?php

namespace App\Model\Entity;

class PostArticle extends AbstractEntity {

    public $id_post_article;
    public $id_author_article;
    public $read_length;
    public $id_post;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_post_article');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_post_article = $data['id_post_article'] ?? null;
        $this->id_author_article = $data['id_author_article'] ?? null;
        $this->read_length = $data['read_length'] ?? null;
        $this->id_post = $data['id_post'] ?? null;
    }    
    
    public function getIdAuthorArticle() {
        return $this->id_author_article;
    }

    public function getReadLength() {
        return $this->read_length;
    }

    public function getIdPost() {
        return $this->id_post;
    }

    public function setIdAuthorArticle($id_author) {
        $this->id_author_article = $id_author;
        return $this;
    }

    public function setReadLength($read_length) {
        $this->read_length = $read_length;
        return $this;
    }

    public function setIdPost($id_post) {
        $this->id_post = $id_post;
        return $this;
    }


}
