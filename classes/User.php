<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author ehugh
 */
class User {
    //put your code here
    private $id;
    private $email;
    private $password;
    
    function __construct($email = "empty", $password = "empty") {
        $this->email = $email;
        $this->password = $password;
    }

    
    
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }


            
            
}
