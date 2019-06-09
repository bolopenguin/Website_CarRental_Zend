<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_formAdd;
    protected $_formCrud;
    protected $_formModify;
    protected $_formDeleteUser;
    protected $_formFaqAdd;
    protected $_formFaqCrud;
    protected $_formFaqModify;
    
    protected $_statsModel;
    protected $_faqModel;
    protected $_userModel;

    public function init() {
        $this->_userModel = new Application_Model_User;
        $this->_statsModel = new Application_Model_Stats;
        $this->_faqModel = new Application_Model_Questions;
                
        $this->view->inserisciForm = $this->addStaffForm();
        $this->view->crudForm = $this->crudStaffForm();
        $this->view->modificaForm = $this->modifyStaffForm();
        $this->view->eliminaUtenteForm = $this->deleteUserForm();
        $this->view->inserisciFaqForm = $this->addFaqForm();
        $this->view->crudFaqForm = $this->crudFaqForm();
        $this->view->modificaFaqForm = $this->modifyFaqForm();
        
        $this->_helper->layout->setLayout('layout');
        $this->_authService = new Application_Service_Auth();
        
        $this->_logger = Zend_Registry::get('log');
    }

    public function indexAction() { 
        
    }

    public function adminareaAction(){
        
    }
    
    
    
    
    public function faqAction(){
        $faq = $this->_getParam('faq', null);
        $this->view->assign(array('faq' => $faq));
        
        $domande = $this->_faqModel->getAllFaq();
        $this->view->assign(array('domande' => $domande));
    }
    
    public function addfaqAction() {
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('faq');
            }
            $form=$this->_formFaqAdd;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                    return $this->render('faq');	
            }
            $values = $form->getValues();
            $this->_logger->info($values['id']);
            $esito = $this->_faqModel->addFaq($values);

            if($esito){
                    return $this->_helper->redirector('faq');
            }
            else{
                //in teoria non ci dovrebb mai finire
                $form->setDescription('Attenzione: qualcosa è andato storto.');
                return $this->render('faq');
            }
    }
    
    private function addFaqForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formFaqAdd = new Application_Form_Admin_Crudfaq_Inserisci();
            $this->_formFaqAdd->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'addfaq',
                            ),
                            'default'
                            ));
            return $this->_formFaqAdd;
    }
    
    
    public function crudfaqAction() {
            if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('faq');
            }
            $form=$this->_formFaqCrud;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                    return $this->render('faq');	
            }
            $values = $form->getValues();
            
            if ($values['opzione'] == 'delete') {
//                $this->_faqModel->deleteFaq($values);
                return $this->_helper->redirector('faq');
                
            } else if ($values['opzione'] == 'modify') {
                $this->_helper->redirector('faq', 'admin', '', array('faq' => $values['id']));
            }
    }
    
    private function crudFaqForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formFaqCrud = new Application_Form_Admin_Crudfaq_Crud();
            $this->_formFaqCrud->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'crudfaq',
                            ),
                            'default'
                            ));
            return $this->_formFaqCrud;
    }
    
    public function modifyfaqAction() {
            if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('faq');
            }
            $form=$this->_formFaqModify;
            $form1=$this->_formFaqCrud;
            if (!$form->isValid($_POST)) {
                    $form1->setDescription('Attenzione: la modifica non è andata a buon fine.');
                    return $this->render('faq');	
            }
            $values = $form->getValues();
            $this->_faqModel->modifyFaq($values);
            $this->_helper->redirector('faq');
    }
    
    private function modifyFaqForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formFaqModify = new Application_Form_Admin_Crudfaq_Modifica();
            $this->_formFaqModify->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'modifyfaq',
                            ),
                            'default'
                            ));
            return $this->_formFaqModify;    
    }
    
    
    
    
    
    
    
    
    public function staffAction(){
        $staff = $this->_userModel->getAllStaff();
        $this->view->assign(array('staff' => $staff));
        
        $user = $this->_getParam('user', null);
        $this->view->assign(array('user' => $user));
    }
    
    public function addstaffAction() {
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('staff');
		}
		$form=$this->_formAdd;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                        return $this->render('staff');	
		}
		$values = $form->getValues();
		$esito = $this->_userModel->addUtente($values);
                
                if($esito){
                        return $this->_helper->redirector('staff');
                }
                else{
                    $form->setDescription('Attenzione: esiste già un utente con quell\'username.');
                    return $this->render('staff');
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
    
    public function crudstaffAction() {
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('staff');
            }
            $form=$this->_formCrud;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                    return $this->render('staff');	
            }
            $values = $form->getValues();
            
            if ($values['opzione'] == 'delete') {
                $this->_userModel->deleteUser($values);
                return $this->_helper->redirector('staff');
                
            } else if ($values['opzione'] == 'modify') {
                $this->_helper->redirector('staff', 'admin', '', array('user' => $values['username']));
            }
    }
    
    private function crudStaffForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formCrud = new Application_Form_Admin_Crudstaff_Crud();
            $this->_formCrud->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'crudstaff',
                            ),
                            'default'
                            ));
            return $this->_formCrud;
    }
    
    public function modifystaffAction() {
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('staff');
            }
            $form=$this->_formModify;
            $form1=$this->_formCrud;
            if (!$form->isValid($_POST)) {
                    $form1->setDescription('Attenzione: la modifica non è andata a buon fine.');
                    return $this->render('staff');	
            }
            $values = $form->getValues();
            $this->_userModel->modifyUser($values);
            $this->_helper->redirector('staff');
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




    
    public function userAction(){
        
    }
    
    public function deleteuserAction(){
            if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('user');
            }
            $form=$this->_formDeleteUser;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: l\'eliminazione non è andata a buon fine.');
                    return $this->render('user');	
            }
            $values = $form->getValues();
            $this->_userModel->deleteUser($values);
            $this->_helper->redirector('user');
    }
    
    public function deleteuserForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formDeleteUser = new Application_Form_Admin_Crudutenti_Elimina();
            $this->_formDeleteUser->setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'deleteuser',
                            ),
                            'default'
                            ));
            return $this->_formDeleteUser;
     
    }
    
    
    
    
    
    
    
    public function statisticheAction(){
        $stats = $this->_statsModel->getStatsYear();
        $this->view->assign(array('stats' => $stats));
    }
   
   
    
    
    
    
    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
}