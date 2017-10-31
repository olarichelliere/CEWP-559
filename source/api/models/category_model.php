<?php

class CategoryModel extends BaseModel
{
    public $id;
    public $name;
    public $description;
  

    protected $TableName = 'categories';
    protected $ModelName = 'CategoryModel';

    //
    // Save the payload as a new Item in to the Database
    //
    public function create($payload)
    {
        // Using sprintf to format the query in a nicer way
        $query = sprintf(
            "INSERT INTO categories (name, description) VALUES ('%s', '%s')",
            $payload->name,
            $payload->description
        );

        $result = $this->db_connection->query($query);
        
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }
        
        $insertedId = $this->db_connection->insert_id;
       
        return $this->getOne($insertedId);
    }

    public function update($id, $payload)
    {
        // Using sprintf to format the query in a nicer way
        $query = sprintf(
            "UPDATE categories SET name = '%s' , description = '%s' WHERE id = %d",
            $payload->name,
            $payload->description,
            $id
        );

        $result = $this->db_connection->query($query);
        
        if (!$result) {
            printf("Error: %s\n", $this->db_connection->error);
            return;
        }

        return $this->getOne($id);
    }

    /**
     * Updates the filename info for the specified item
     */
    public function updateImage($id, $filename) 
    {
        return $this->updateFieldById($id, 'image', $filename);
    }
}

