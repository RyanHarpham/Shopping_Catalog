<?php
class Person {
    private $fName;
    private $lName;
    private $alias;
    private $email;
    private $password;
      
    function __construct($fName, $lName, $alias, $email, $password) {
        $this->fName = $fName;
        $this->lName = $lName;
        $this->alias = $alias;
        $this->email = $email;
        $this->password = $password;
    }
    function getFName() {
        return $this->fName;
    }
    function getLName() {
        return $this->lName;
    }
    function getAlias() {
        return $this->alias;
    }
    function getEmail() {
        return $this->email;
    }
    function setFName($fName) {
        $this->fName = $fName;
    }
    function setLName($lName) {
        $this->lName = $lName;
    }
    function setAlias($alias) {
        $this->alias = $alias;
    }
    function setEmail($email) {
        $this->email = $email;
    }
    
    function setPassword($password) {
        $this->password = $password;
    }
    
    function getPassword() {
        return $this->password;
    }
}
