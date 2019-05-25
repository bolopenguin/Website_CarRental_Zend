<?php

class UserController extends Zend_Controller_Action{
    
    protected $usercatalogModel;
    protected $_logger;
    public function init() {
        $this->_helper->layout->setLayout('layout'); //helper layout che definisce l'attivazione del layout all'interno della nostra applicazione
        // setLayout va a recuperare il file main.phtml nella cartella di layout che abbiamo deinito nel file application.ini
        $this->_logger = Zend_Registry::get('log');
        $this->_usercatalogModel = new Application_Model_Catalog();
    
    }



}