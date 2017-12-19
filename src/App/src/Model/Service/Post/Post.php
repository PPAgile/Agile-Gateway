<?php
declare(strict_types=1);

namespace App\Model\Service\Post;

abstract class Post {
    public $id;
    public $publishDate;
    public $likes;
    public $title;
    public $url;
    public $source;
    public $picture;
    public $comments;
    public $categories;
    public $dateAdded;
    
    protected function __construct() {
        ;
    }     
    
    protected function addComment() {
        
    }
    
    protected function addCategory() {
        
    }
    
    abstract protected function addTypePrefix();
    
    public function getId() {
        return $this->id;
    }

    public function getPublishDate() {
        return $this->publishDate;
    }

    public function getLikes() {
        return $this->likes;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getSource() {
        return $this->source;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function getComments() {
        return $this->comments;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setPublishDate($publishDate) {
        $this->publishDate = $publishDate;
        return $this;
    }

    public function setLikes($likes) {
        $this->likes = $likes;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function setSource($source) {
        $this->source = $source;
        return $this;
    }

    public function setPicture($picture) {
        $this->picture = $picture;
        return $this;
    }

    public function setComments($comments) {
        $this->comments = $comments;
        return $this;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
        return $this;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
        return $this;
    }



}

