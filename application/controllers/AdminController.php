<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_formAdd;
    protected $_formCrud;
    protected $_formModify;
    protected $_userModel;
    
    public function init() {
        $this->_userModel = new Application_Model_User;
        
        $this->view->inserisciForm = $this->addStaffForm();
        $this->view->crudForm = $this->crudStaffForm();
        $this->view->modificaForm = $this->modifyStaffForm();
        
        $this->_helper->layout->setLayout('layout');
        $this->_authService = new Application_Service_Auth();
    }

    public function indexAction() { 
    }

    public function adminareaAction(){
        
    }
    
    public function crudfaqAction(){
        
    }
    
    public function crudstaffAction(){
        $user = $this->_getParam('user', null);
        $this->view->assign(array('user' => $user));
    }
    
    public function addstaffAction() {
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('crudstaff');
		}
		$form=$this->_formAdd;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                        return $this->render('crudstaff');	
		}
		$values = $form->getValues();
		$esito = $this->_userModel->addUtente($values);
                
                if($esito){
                        return $this->_helper->redirector('crudstaff');
                }
                else{
                    $form->setDescription('Attenzione: esiste già un utente con quell\'username.');
                    return $this->render('crudstaff');
                }
                
        }
    
    private function addStaffForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formAdd = new Application_Form_Admin_Crudstaff_Inserisci();
            $this->_formAdd->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'addstaff',
                            ),
                            'default'
                            ));
            return $this->_formAdd;
    }
    
    
    public function crudAction() {
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('crudstaff');
            }
            $form=$this->_formCrud;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                    return $this->render('crudstaff');	
            }
            $values = $form->getValues();
            
            if ($values['opzione'] == 'delete') {
                $this->_userModel->deleteUser($values);
                return $this->_helper->redirector('crudstaff');
                
            } else if ($values['opzione'] == 'modify') {
                $this->_helper->redirector('crudstaff', 'admin', '', array('user' => $values['username']));
            }
    }
    
    private function crudStaffForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formCrud = new Application_Form_Admin_Crudstaff_Crud();
            $this->_formCrud->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'crud',
                            ),
                            'default'
                            ));
            return $this->_formCrud;
    }
    
    public function modifystaffAction() {
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('crudstaff');
            }
            $form=$this->_formModify;
            $form1=$this->_formCrud;
            if (!$form->isValid($_POST)) {
                    $form1->setDescription('Attenzione: la modifica non è andata a buon fine.');
                    return $this->render('crudstaff');	
            }
            $values = $form->getValues();
            $this->_userModel->modifyUser($values);
            $this->_helper->redirector('crudstaff');
    }
    
    private function modifyStaffForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formModify = new Application_Form_Admin_Crudstaff_Modifica();
            $this->_formModify->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'modifystaff',
                            ),
                            'default'
                            ));
            return $this->_formModify;
        
    }
    
    public function deleteuserAction(){
        
    }
    
    public function statisticheAction(){
        
    }

    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
}