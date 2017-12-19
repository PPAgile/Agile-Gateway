<?php
declare(strict_types = 1);

namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use App\Model\Entity\AbstractEntity;
use App\Model\Db\Exception\NotFound;

abstract class AbstractTable {

    protected $tableGateway;
    protected $tableName = null;
    protected $entityName = null;
    protected $primaryKey = null;

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        if (!isset($this->tableName) || !isset($this->entityName) || !isset($this->primaryKey)) {
            throw new \Exception("Expected params not set");
        }

        if (!isset($tableGateway)) {
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new $this->entityName());
            $this->tableGateway = new TableGateway($this->tableName, $dbAdapter);
        } else {
            $this->tableGateway = $tableGateway;
        }
    }

    public function fetchAll() {
        $rowset = $this->tableGateway->select();
        return $this->_instantiateResult($rowset);
    }

    public function getById(int $id) {
        $id = (int) $id;
        $condition = array($this->primaryKey => $id);

        return $this->getByCondition($condition);
    }

    public function getByCondition(array $condition) {
        $rowset = $this->tableGateway->select($condition);

        return $this->_instantiateResult($rowset);
    }

    public function save(AbstractEntity $entity) {
        if (!is_a($entity, $this->entityName)) {
            throw new \Exception('Invalid entity type while saving to table: ' . $entity);
        }

        $data = $this->_prepareSaveData($entity);

        if (is_null($entity->getId())) {
            $this->tableGateway->insert($data);
            $entity->setId($this->tableGateway->getLastInsertValue());
        } else {
            if ($this->GetById((int) $entity->getId())) {
                $this->tableGateway->update($data, array($this->primaryKey => (int) $entity->getId()));
            } else {
                throw new \Exception('Id does not exist');
            }
        }
    }

    public function delete(AbstractEntity $entity) {
        $this->tableGateway->delete(array($this->primaryKey => (int) $entity->getId()));
    }

    protected function _prepareSaveData(AbstractEntity $entity): array {
        $resultArray = get_object_vars($entity);
        unset($resultArray[$this->primaryKey]);

        return $resultArray;
    }

    protected function _instantiateResult(ResultSet $rowset) {
        $resultArray = [];
        foreach ($rowset as $row) {
            $resultArray[] = $row;
        }

        $count = count($resultArray);
        switch ($count) {
            case 0:
                return NULL;
            case 1:
                $rowArray = is_a($resultArray[0], 'ArrayObject') ? $resultArray[0]->getArrayCopy() : $rowArray;

                //create entity object
                $entity = new $this->entityName($rowArray);
                return $entity;
            default:
                $rows = [];
                foreach ($resultArray as $row) {
                    $rowArray = is_a($row, 'ArrayObject') ? $row->getArrayCopy() : $rowArray;
                    //create entity object
                    $entity = new $this->entityName($rowArray);

                    $rows[] = $entity;
                }

                return $rows;
        }
    }

}
