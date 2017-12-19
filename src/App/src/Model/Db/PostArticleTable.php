<?php

declare(strict_types = 1);

namespace App\Model\Db;

use Zend\Db\TableGateway\TableGateway;
use App\Model\Entity\PostArticle;
use Zend\Db\ResultSet\ResultSet;
use App\Model\Db\AbstractTable;
use App\Enum\DbTablesList;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class PostArticleTable extends AbstractTable {

    const PRIMARY_KEY = 'id_post_article';

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway = null) {
        $this->entityName = PostArticle::class;
        $this->primaryKey = self::PRIMARY_KEY;
        $this->tableName = DbTablesList::toString(DbTablesList::post_article);

        parent::__construct($dbAdapter, $tableGateway);
    }

    public function getByIdPost($idPost) {
        $condition = array('id_post' => $idPost);

        return $this->getByCondition($condition);
    }

    /*public function fetchAllOrdered() {
        $artistTable = $this->tableGateway;


        $rowset = $artistTable->select(function (Select $select) {
            $select->order('id_post_article DESC');
        });

        var_dump((array) $rowset);
    }*/

}
