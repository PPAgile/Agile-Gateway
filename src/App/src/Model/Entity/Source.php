<?php

namespace App\Model\Entity;

class Source extends AbstractEntity {

    public $id_source;
    public $name;
    public $url;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_source');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_source = $data['id_source'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->url = $data['url'] ?? null;
    } 
    public function getName() {
        return $this->name;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }


}
