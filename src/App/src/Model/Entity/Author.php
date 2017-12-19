<?php

namespace App\Model\Entity;

class Author extends AbstractEntity {

    public $id_author;
    public $name;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_author');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_author = (!empty($data['id_author'])) ? $data['id_author'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
}
