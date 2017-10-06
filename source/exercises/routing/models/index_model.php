<?php

class IndexModel
{
    public $title;
    public $description;

    public function __construct(){
        $this->title = 'Index Page';
        $this->description = 'Home Page';
    }
}