<?php

namespace App\Model\Entity;

class AuthorComment extends AbstractEntity {

    public $id_author_comment;
    public $id_author;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_author_comment');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_author_comment = $data['id_author_comment'] ?? null;
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
