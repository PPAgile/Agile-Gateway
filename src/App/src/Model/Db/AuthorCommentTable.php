<?php
declare(strict_types=1);
namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\AuthorComment;
use Zend\Db\ResultSet\ResultSet;
use App\Model\Db\AbstractTable;
use App\Enum\DbTablesList;
use Zend\Db\Adapter\Adapter;

class AuthorCommentTable extends AbstractTable {
    const PRIMARY_KEY = 'id_author_comment';

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        $this->entityName = AuthorComment::class;
        $this->primaryKey = self::PRIMARY_KEY;
        $this->tableName = DbTablesList::toString(DbTablesList::author_comment);
        
        parent::__construct($dbAdapter, $tableGateway);
    }
    
    public function getByIdAuthor(int $idAuthor) {
        $condition = array('id_author' => $idAuthor);

        return $this->getByCondition($condition);
    }

}
