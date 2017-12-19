<?php

namespace App\Model\Entity;

class Post extends AbstractEntity {

    public $id_post;
    public $date_published;
    public $likes;
    public $title;
    public $url;
    public $id_source;
    public $id_picture;
    public $date_added;

    public function __construct(array $data = []) {
        $this->setIdEntityPropertyName('id_post');
        parent::__construct($data);
    }

    public function exchangeArray(array $data) {
        $this->id_post = $data['id_post'] ?? null;
        $this->date_published = $data['date_published'] ?? null;
        $this->likes = $data['likes'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->id_source = $data['id_source'] ?? null;
        $this->id_picture = $data['id_picture'] ?? null;
        $this->date_added = $data['date_added'] ?? null;
    }    
    
    public function getDatePublished() {
        return $this->date_published;
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

    public function getIdSource() {
        return $this->id_source;
    }

    public function getIdPicture() {
        return $this->id_picture;
    }

    public function setDatePublished($date_published) {
        $this->date_published = $date_published;
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

    public function setIdSource($id_source) {
        $this->id_source = $id_source;
        return $this;
    }

    public function setIdPicture($id_picture) {
        $this->id_picture = $id_picture;
        return $this;
    }

    public function getDateAdded() {
        return $this->date_added;
    }

    public function setDateAdded($date_added) {
        $this->date_added = $date_added;
        return $this;
    }



}
