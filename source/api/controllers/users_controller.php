<?php

class UsersController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }


    public function create($payload)
    {


        if (!array_key_exists('username', $payload)) {
            throw new Exception('`username` should be provided!');
        } elseif (!array_key_exists('password', $payload)) {
            throw new Exception('`password` should be provided!');
        }

        
        $payload->password=password_hash($payload->password,PASSWORD_BCRYPT);
        
        return $this->model->create($payload);
    }
    
    public function login($payload)
       {


        if (!array_key_exists('username', $payload)) {
            throw new Exception('`username` should be provided!');
        } elseif (!array_key_exists('password', $payload)) {
            throw new Exception('`password` should be provided!');
        }
        $user = $this->model->getUserByUsername($payload->username);
        
        
        if(!password_verify($payload->password,$user->password)){
            throw new Exception("Invalue username or passwrd",401);
        }
        
        $token=bin2hex(random_bytes(64));
                      
        $this->model->storeToken($user->id, $token);
        
        return array('token' => $token, 'isAdmin'=> $user->isadmin);    
            
            
        //$payload->password=password_hash($payload->password,PASSWORD_BCRYPT); 
        //return $this->model->create($payload);
    }

    public function verify($headers){
        if (!array_key_exists('Authorization', $headers)) {
            throw new Exception('`Authorization` should be provided!');
        }
        
        $token=explode(' ',$headers['Authorization'])[1];
        
        return $this->model->verifyToken($token);
    }

    public function loggedInOnly($headers){
        if(!$this->verify($headers)) {
            throw new Exception("Only Authroized users can access this resource", 401);
        }
    }

    public function adminOnly(){

    }
}