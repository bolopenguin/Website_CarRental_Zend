<?php

class Application_Model_Catalog extends App_Model_Abstract {

    public function __construct() {
        $this->_logger = Zend_Registry::get('log');
    }

    public function getAllAuto($paged){
        return $this->getResource('Auto')->getAllAuto($paged);
    }
 
    public function getAuto($targa){
        return $this->getResource('Auto')->getAuto($targa);
    }
   public function getFilteredAuto($values){
       return $this->getResource('Auto')->getFilteredAuto($values);
   }
   
   public function addAuto($values){
       return $this->getResource('Auto')->addAuto($values);
   }
   
    public function deleteAuto($values){
       return $this->getResource('Auto')->deleteAuto($values);
   }
   public function modifyAuto($values){
       return $this->getResource('Auto')->modifyAuto($values);
   }
   
      public function getUserFilteredAuto($values,$tmp,$paged){
       return $this->getResource('Auto')->getUserFilteredAuto($values,$tmp,$paged);
   }
   
   public function getAvaiableAuto($tmp,$paged){
        return $this->getResource('Auto')->getAvaiableAuto($tmp,$paged);
    }
    
    public function getNotAvaiableAuto($period){                
        return $this->getResource('Prenotazione')->getNotAvaiableAuto($period);
    }
}