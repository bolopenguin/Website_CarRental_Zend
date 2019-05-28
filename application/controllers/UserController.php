<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        $role=$this->_getParam('role',2);
        $this->_helper->layout->setLayout('layout'.$role);
        $this->_authService = new Application_Service_Auth();
    }

    public function indexAction() {
        
    }

    
    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
    
    public function gestioneprofiloAction(){
       
    }

}
