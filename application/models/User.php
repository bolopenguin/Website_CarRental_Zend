<?php

class Application_Model_User extends App_Model_Abstract {

    public function __construct() {
        
    }

    public function getUserByName($info) {
        return $this->getResource('Utente')->getUserByName($info);
    }
    public function addUtente($values) {
        return $this->getResource('Utente')->addUtente($values);
    }

}
