<?php

class UsersModel extends BaseModel
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $isadmin;


    protected $TableName = 'users';
    protected $ModelName = 'UsersModel';


    public function getUserByUsername($username){
        $query = "SELECT * FROM {$this->TableName}  WHERE username = '$username' ";
        $result = $this->db_connection->query($query);
        
        error_log("getUserByName");
        
        if (!$result) {
            throw new Exception("Database error: {$this->db_connection->error}", 500);            
        }
     
        if($result->num_rows !=1){
            throw new Exeption ('User does not exist', 400);
        }
        
        return $result->fetch_object($this->ModelName);
    }
    
    public function storeToken($userId, $token){
        $generatedDateTime = date("Y-m-d H:i:s"); 
        $expirationDateTime = date("Y-m-d H:i:s", strtotime('+2 hours'));
        
        $query =  "INSERT INTO tokens SET userId='$userId', token='$token', 
                    lastUpdateDateTime='$generatedDateTime', expirationDateTime='$expirationDateTime' ";
     
        $result = $this->db_connection->query($query);
 /*   
        error_log("getUserByName");
        
        if (!$result) {
            throw new Exception("Database error: {$this->db_connection->error}", 500);            
        }
     
        if($result->num_rows !=1){
            throw new Exeption ('User does not exist', 400);
        }
        return $result->fetch_object($this->ModelName);
*/        
    }
    public function verifyToken($token){
        $query = "SELECT * FROM tokens WHERE token = '$token' and expirationDateTime > NOW() ";
        $result = $this->db_connection->query($query);

        if (!$result) {
            throw new Exception("Unauthorized token: {$this->db_connection->error}", 401);
        }

        if ($result->num_rows != 1) {
            return false;
        }
        return true;
    }


}
