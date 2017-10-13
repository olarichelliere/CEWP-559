<?php

class BaseModel
{
    
    protected $db_connection;
    
    function __construct($connection = null){
        if(!empty($connection)){
            $this->db_connection = $connection;
        }
    }
    
    
    public function getAll(){
        $items = array();
        $query = "SELECT * FROM {$this->TableName}";
        $result = $this->db_connection->query($query);
        
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }
        
        while ($item = $result->fetch_object('ItemModel')) {
            $items[] = $item;
        }
        $this->_data = $items;
    }

    public function getOne($id){
        
        $query = "SELECT * FROM {$this->TableName} WHERE id = $id";
        
        $result = $this->db_connection->query($query);
        
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }
        
        $item = $result->fetch_object($this->ClassName);
        $this->_data = $item;
    }

    public function deleteOne($id){
        // Using sprintf to format the query in a nicer way
        $query = "DELETE FROM {$this->TableName} WHERE id = $id";
        
        $result = $this->db_connection->query($query);
       
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }
    }
}