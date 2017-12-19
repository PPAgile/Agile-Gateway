<?php

declare(strict_types = 1);

namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\Author;
use Zend\Db\ResultSet\ResultSet;
use App\Model\Db\AbstractTable;
use App\Enum\DbTablesList;
use Zend\Db\Adapter\Adapter;

class AuthorTable extends AbstractTable {

    const PRIMARY_KEY = 'id_author';

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        $this->entityName = Author::class;
        $this->primaryKey = self::PRIMARY_KEY;
        $this->tableName = DbTablesList::toString(DbTablesList::author);

        parent::__construct($dbAdapter, $tableGateway);
    }

    public function getByName(string $name) {
        $condition = array('name' => $name);

        return $this->getByCondition($condition);
    }

}
