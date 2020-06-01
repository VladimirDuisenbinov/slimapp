<?php

namespace Models;

class Book {

    private $title;
    private $author;
    private $date_published;
    private $pages;

    public function __construct($title, $author, $date_published, $pages) {
        $this->title = $title;
        $this->author = $author;
        $this->date_published = $date_published;
        $this->pages = $pages;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDatePublished() {
        return $this->date_published;
    }

    public function getPages() {
        return $this->pages;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setDatePublished($date_published) {
        $this->date_published = $date_published;
    }

    public function setPages($pages) {
        $this->pages = $pages;
    }

}