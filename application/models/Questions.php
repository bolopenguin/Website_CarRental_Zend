<?php

class Application_Model_Questions extends App_Model_Abstract {

    public function __construct() {
        
    }
 
    public function getAllFaq(){
        return $this->getResource('Faq')->getAllFaq();
    }
    
    public function getFaqById($id){
        return $this->getResource('Faq')->getFaqById($id);
    }
    
    public function getIdMax(){
        return $this->getResource('Faq')->getIdMax();
    }
    
    public function addFaq($values){
        return $this->getResource('Faq')->addFaq($values);
    }

    public function modifyFaq($values){
        return $this->getResource('Faq')->modifyFaq($values);
    }
}
