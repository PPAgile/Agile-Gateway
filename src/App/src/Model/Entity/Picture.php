<?php

namespace App\Model\Entity;

class Picture extends AbstractEntity {

    public $id_picture;
    public $location;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_picture');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_picture = $data['id_picture'] ?? null;
        $this->location = $data['location'] ?? null;
    }   
    
    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }


}
