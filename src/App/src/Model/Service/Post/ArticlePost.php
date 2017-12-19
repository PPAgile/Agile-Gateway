<?php

declare(strict_types = 1);

namespace App\Model\Service\Post;

use Zend\Json\Json;
use Zend\Db\Adapter\Adapter;
use Zend\Uri\Http;
use App\Model\Entity\{
    Source,
    Picture,
    Post,
    Author,
    PostArticle,
    AuthorArticle
};
use App\Model\Db\{
    SourceTable,
    PictureTable,
    PostTable,
    AuthorTable,
    PostArticleTable,
    AuthorArticleTable
};
use \App\Enum\PostTypes;

class ArticlePost extends \App\Model\Service\Post\Post implements PostStrategyInterface {

    public $authorArticle;
    public $readLength;
    public $idPost;

    public function __construct() {
        ;
    }

    public function load(Adapter $adapter, $id) {
        //load post article by id
        $postArticle = $this->_loadPostArticle($adapter, (int) $id);
        //load post information to post article
        $post = $this->_loadPost($adapter, (int) $postArticle->getIdPost());
        //load author of post article
        $this->_loadAuthor($adapter, (int) $postArticle->getIdAuthorArticle());
        //load source
        $this->_loadSource($adapter, (int) $post->getIdSource());
        //load picture
        $this->_loadPicture($adapter, (int) $post->getIdPicture());
        
        return $this;
    }
    
    public function create(Adapter $adapter, $data) {
        $data = $this->_validate($data);

        try {
            //begin transaction
            $adapter->getDriver()->getConnection()->beginTransaction();

            //check if source exist, if not create new source
            $this->_createSource($adapter, $data);
            //create new picture
            $this->_createPicture($adapter, $data);
            //check if author exists, if not create new author
            $this->_createAuthor($adapter, $data);
            //create post and link picture and source
            $this->_createPost($adapter, $data);
            //create post article and link to post
            $this->_createPostArticle($adapter, $data);

            //commit
            $adapter->getDriver()->getConnection()->commit();
        } catch (\Exception $e) {
            //rollback
            $adapter->getDriver()->getConnection()->rollback();
        }
        return $this;
    }

    protected function _validate($data) {
        $decoded = Json::decode($data);
        return $decoded->article;
    }

    protected function _createSource(Adapter $adapter, $data) {
        $table = new SourceTable($adapter);
        $source = $table->getByName($data->author);

        if (is_null($source)) {
            $source = (new Source())->setName($data->author)
                    ->setUrl((new Http($data->url))->getHost());
            $table->save($source);
        }

        $this->setSource($source);
        return $source;
    }

    protected function _createPicture(Adapter $adapter, $data) {
        $table = new PictureTable($adapter);
        $picture = (new Picture())->setLocation($data->picture->url);
        $table->save($picture);

        $this->setPicture($picture);
        return $picture;
    }

    protected function _createAuthor(Adapter $adapter, $data) {
        $table = new AuthorTable($adapter);
        $author = $table->getByName($data->author);

        if (is_null($author)) {
            $author = (new Author())->setName($data->author);
            $table->save($author);
        }

        $table = new AuthorArticleTable($adapter);
        $authorArticle = $table->getByIdAuthor((int) $author->getId());
        if (is_null($authorArticle)) {
            $authorArticle = (new AuthorArticle())->setIdAuthor($author->getId());
            $table->save($authorArticle);
        }
        $authorArticle->name = $author->getName();
        $this->setAuthorArticle($authorArticle);
        return $authorArticle;
    }

    protected function _createPost(Adapter $adapter, $data) {
        $table = new PostTable($adapter);
        $post = (new \App\Model\Entity\Post())->setDatePublished((new \DateTime($data->publish_date))->format("Y-m-d\TH:i:s"))
                ->setLikes($data->likes)
                ->setTitle($data->title)
                ->setUrl($data->url)
                ->setIdPicture($this->getPicture()->getId())
                ->setIdSource($this->getSource()->getId())
                ->setDateAdded((new \DateTime($data->date_added))->format("Y-m-d\TH:i:s"));

        $table->save($post);

        $this->setLikes($post->getLikes());
        $this->setTitle($post->getTitle());
        $this->setUrl($post->getUrl());
        $this->setPublishDate($post->getDatePublished());
        $this->setIdPost($post->getId());
        $this->setDateAdded($post->getDateAdded());


        return $post;
    }

    protected function _createPostArticle(Adapter $adapter, $data) {
        $table = new PostArticleTable($adapter);
        $postArticle = (new PostArticle())->setReadLength($data->read_length)
                ->setIdPost($this->getIdPost())
                ->setIdAuthorArticle($this->getAuthorArticle()->getId());
        $table->save($postArticle);

        $this->setReadLength($postArticle->getReadLength());
        $this->setId($postArticle->getId());

        return $postArticle;
    }
    
    protected function _loadPostArticle(Adapter $adapter, int $id) {
        $table = new PostArticleTable($adapter);
        $postArticle = $table->getById($id);
        
        $this->setId($id);
        $this->setReadLength($postArticle->getReadLength());
        
        return $postArticle;
    }
    
    protected function _loadPost(Adapter $adapter, int $id) {
        $table = new PostTable($adapter);
        $post = $table->getById($id);

        $this->setLikes($post->getLikes());
        $this->setTitle($post->getTitle());
        $this->setUrl($post->getUrl());
        $this->setPublishDate($post->getDatePublished());
        $this->setIdPost($post->getId());
        $this->setDateAdded($post->getDateAdded());
        
        return $post;
    }

    protected function _loadAuthor(Adapter $adapter, int $id) {
        $table = new AuthorArticleTable($adapter);
        $authorArticle = $table->getById($id);
        $table = new AuthorTable($adapter);
        $author = $table->getById((int) $authorArticle->getIdAuthor());
        
        $authorArticle->name = $author->GetName();
        $this->setAuthorArticle($authorArticle);
        
        return $authorArticle;   
    }
    
    protected function _loadSource(Adapter $adapter, int $id) {
        $table = new SourceTable($adapter);
        $source = $table->getById($id);
        $this->setSource($source);
        
        return $source;
    }
    
    protected function _loadPicture(Adapter $adapter, int $id) {
        $table = new PictureTable($adapter);
        $picture = $table->getById($id);
        $this->setPicture($picture);
        
        return $picture;
    }
    
    public function addTypePrefix() {
        $result = new \stdClass();
        $result->{PostTypes::toString(PostTypes::article)} = $this;
        
        return $result;
    }
    public function getAuthorArticle() {
        return $this->authorArticle;
    }

    public function getReadLength() {
        return $this->readLength;
    }

    public function setAuthorArticle($author) {
        $this->authorArticle = $author;
        return $this;
    }

    public function setReadLength($readLength) {
        $this->readLength = $readLength;
        return $this;
    }

    public function getIdPost() {
        return $this->idPost;
    }

    public function setIdPost($id_post) {
        $this->idPost = $id_post;
        return $this;
    }
    
    

}
