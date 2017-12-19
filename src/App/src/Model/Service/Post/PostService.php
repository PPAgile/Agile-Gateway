<?php
declare(strict_types = 1);

namespace App\Model\Service\Post;

use App\Enum\PostTypes;
use App\Model\Db\ {
    PostArticleTable,
    CommentTable,
    PostTable
};
use Zend\Db\Adapter\Adapter;
use Zend\Json\Json;

class PostService {

    public function createPost(Adapter $adapter, $data = null) {
        
        try {            
        $postStrategy = new PostStrategyContext($this->_extractPostType($data));
      
        } catch (Exception $e) {
            throw $e;
        }
        return $postStrategy->createPost($adapter, $data);
    }
    
    public function getPosts(Adapter $adapter, array $queryParams) {
        $result = [];
        
        
        //get all articles
        $table = new PostArticleTable($adapter);
        $articles = (array) $table->fetchAll();
        //$table->fetchAllOrdered();

        foreach ($articles as $article) {
            $result[] = $this->_getPost($adapter, (int) $article->getId());
        }
        
        return $result;
    }
    
    protected function _extractPostType($data) {
        $type = Json::decode($data);

        switch(key((array) $type)) {
            case PostTypes::toString(PostTypes::article):
              return PostTypes::article;
          default:
              throw new Exception('Error while extracting post type');
        }
    }
    
    protected function _getPost($adapter, int $id) {
        $postStrategy = new PostStrategyContext(PostTypes::article);
        $row = $postStrategy->loadPost($adapter, $id);
        return $row->addTypePrefix();
    }
      
    public function addLike($adapter, int $idPost) {
        $table = new PostTable($adapter);
        $post = $table->getById($idPost);
        
        $post->likes++;    
        $table->save($post);
        
        $responseObject = new \stdClass();
        $responseObject->likes = $post->likes;
        return $responseObject;
    }

}
