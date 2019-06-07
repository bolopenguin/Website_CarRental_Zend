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
    
    public function modifyUser($values){
        return $this->getResource('Utente')->modifyUser($values);
    }

    public function getPrenotazioni($values){
        return $this->getResource('Prenotazione')->getPrenotazioni($values);
    }
    
    public function getAllStaff(){
        return $this->getResource('Utente')->getAllStaff();
    }
    
    public function deleteUser($values){
        return $this->getResource('Utente')->deleteUser($values);
    }
}
