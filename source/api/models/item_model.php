<?php

class ItemModel extends BaseModel
{

    public $id;
    public $name;
    public $description;
    public $price;

    public $_data;
    
    protected $db_connection;
    
    protected $TableName = 'items';
    protected $ClassName = 'ItemModel';
    
    function __construct($connection = null){
        if(!empty($connection)){
            $this->db_connection = $connection;
        }
    }

    //
    // Save the payload as a new Item in to the Database
    // 
    public function create($payload){
        // Using sprintf to format the query in a nicer way
        $query = sprintf("INSERT INTO items (name, description, price) VALUES ('%s', '%s', '%s')", 
            $payload->name, 
            $payload->description, 
            $payload->price);

        $result = $this->db_connection->query($query);
        
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }

        $insertedId = $this->db_connection->insert_id;
        return $this->getOne($insertedId);
    }

    public function update($id, $payload){
        // Using sprintf to format the query in a nicer way
        $query = sprintf("UPDATE items SET name = '%s' , description = '%s', price = '%s' WHERE id = '%d'", 
            $payload->name, 
            $payload->description, 
            $payload->price,
            $id);

        $result = $this->db_connection->query($query);
        
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }

        return $this->getOne($id);
    }    


}