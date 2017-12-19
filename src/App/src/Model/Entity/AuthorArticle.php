<?php

namespace App\Model\Entity;

class AuthorArticle extends AbstractEntity {

    public $id_author_article;
    public $id_author;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_author_article');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_author_article = $data['id_author_article'] ?? null;
        $this->id_author = $data['id_author'] ?? null;
    }    
    
    public function getIdAuthor() {
        return $this->id_author;
    }

    public function setIdAuthor($id_author) {
        $this->id_author = $id_author;
        return $this;
    }



}
