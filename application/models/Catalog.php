<?php

class Application_Model_Catalog extends App_Model_Abstract {

    public function __construct() {
        $this->_logger = Zend_Registry::get('log');
    }

    public function getAllAuto($paged){
        return $this->getResource('Auto')->getAllAuto($paged);
    }
  
}