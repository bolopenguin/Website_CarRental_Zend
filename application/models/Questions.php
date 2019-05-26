<?php

class Application_Model_Questions extends App_Model_Abstract {

    public function __construct() {
        $this->_logger = Zend_Registry::get('log');
    }
 
    public function getAllFaq(){
        return $this->getResource('Faq')->getAllFaq();
    }
   
}