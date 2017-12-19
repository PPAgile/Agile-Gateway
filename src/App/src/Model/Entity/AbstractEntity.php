<?php

namespace App\Model\Entity;

abstract class AbstractEntity {

    protected $_idEntityPropertyName = null;

    public function __construct(array $data = []) {
        if (!isset($this->_idEntityPropertyName)) {
            throw new Exception('Id entity property name must be set.');
        }
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getId() {
        return $this->{$this->_idEntityPropertyName};
    }

    public function setId($id) {
        $this->{$this->_idEntityPropertyName} = $id;
    }

    abstract public function exchangeArray(array $data);

    public function setIdEntityPropertyName($name) {
        $this->_idEntityPropertyName = $name;
    }

}
