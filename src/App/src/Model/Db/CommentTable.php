<?php
declare(strict_types=1);
namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\Comment;
use Zend\Db\ResultSet\ResultSet;
use App\Model\Db\AbstractTable;
use App\Enum\DbTablesList;
use Zend\Db\Adapter\Adapter;

class CommentTable extends AbstractTable {
    const PRIMARY_KEY = 'id_comment';

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        $this->entityName = Comment::class;
        $this->primaryKey = self::PRIMARY_KEY;
        $this->tableName = DbTablesList::toString(DbTablesList::comment);
        
        parent::__construct($dbAdapter, $tableGateway);
    }

}
