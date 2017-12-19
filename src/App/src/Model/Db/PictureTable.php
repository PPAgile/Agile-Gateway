<?php
declare(strict_types=1);
namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\Picture;
use Zend\Db\ResultSet\ResultSet;
use App\Model\Db\AbstractTable;
use App\Enum\DbTablesList;
use Zend\Db\Adapter\Adapter;

class PictureTable extends AbstractTable {
    const PRIMARY_KEY = 'id_picture';

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        $this->entityName = Picture::class;
        $this->primaryKey = self::PRIMARY_KEY;
        $this->tableName = DbTablesList::toString(DbTablesList::picture);
        
        parent::__construct($dbAdapter, $tableGateway);
    }

}
