<?php

class ItemController
{
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAll(){
        $this->model->getItems();
    }
    
    public function getID($id){
        $this->model->getItemByID($id);
    }
    
    public function create($json_date){
        //parse
        // create model
        //save model
        $this->model->save();
    }
    
}