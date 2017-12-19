<?php
declare(strict_types=1);
namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\Post;
use Zend\Db\ResultSet\ResultSet;
use App\Model\Db\AbstractTable;
use App\Enum\DbTablesList;
use Zend\Db\Adapter\Adapter;

class PostTable extends AbstractTable {
    const PRIMARY_KEY = 'id_post';

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        $this->entityName = Post::class;
        $this->primaryKey = self::PRIMARY_KEY;
        $this->tableName = DbTablesList::toString(DbTablesList::post);
        
        parent::__construct($dbAdapter, $tableGateway);
    }

}
