<?php

class AdminController extends Zend_Controller_Action {
    
    protected $_formAdd;
    protected $_formCrud;
    protected $_formModify;
    protected $_formDeleteUser;
    protected $_formFaqAdd;
    protected $_formFaqCrud;
    protected $_formFaqModify;
    protected $_formUserSelect;
    protected $_formChat;
    
    protected $_statsModel;
    protected $_faqModel;
    protected $_userModel;
    protected $_chatModel;

    public function init() {
        $this->_userModel = new Application_Model_User;
        $this->_statsModel = new Application_Model_Stats;
        $this->_faqModel = new Application_Model_Questions;
        $this->_chatModel = new Application_Model_Chat();
                
        $this->view->inserisciForm = $this->addStaffForm();
        $this->view->crudForm = $this->crudStaffForm();
        $this->view->modificaForm = $this->modifyStaffForm();
        $this->view->eliminaUtenteForm = $this->deleteUserForm();
        $this->view->inserisciFaqForm = $this->addFaqForm();
        $this->view->crudFaqForm = $this->crudFaqForm();
        $this->view->modificaFaqForm = $this->modifyFaqForm();
        $this->view->selectUserForm = $this->SelectUserForm();
        $this->view->chatForm = $this->sendChatForm();
        
        $this->_helper->layout->setLayout('layout');
        $this->_authService = new Application_Service_Auth();
    }

    public function indexAction() { 
        
    }

    public function adminareaAction(){
        $this->view->headTitle('Area Riservata');
    }
    
    
    
    
    public function faqAction(){
        $faq = $this->_getParam('faq', null);
        $this->view->assign(array('faq' => $faq));
        
        $domande = $this->_faqModel->getAllFaq();
        $this->view->assign(array('domande' => $domande));
        $this->view->headTitle('Area Riservata');
    }
    
    public function addfaqAction() {
            $domande = $this->_faqModel->getAllFaq();
            $this->view->assign(array('domande' => $domande));
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('faq');
            }
            $form=$this->_formFaqAdd;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                    return $this->render('faq');	
            }
            $values = $form->getValues();
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
            $domande = $this->_faqModel->getAllFaq();
            $this->view->assign(array('domande' => $domande));
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
        $this->view->headTitle('Area Riservata');
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
        $this->view->headTitle('Area Riservata');
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
            $this->_userModel->deleteUsers($values);
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
        $this->view->headTitle('Area Riservata');
        $stats = $this->_statsModel->getStatsYear();
        $this->view->assign(array('stats' => $stats));
    }
   
   
    public function chatAction(){
    
             $selected = $this->_getParam('selected',0);
             $sended = $this->_getParam('sended',0);
             
             if($selected == 1 && $sended == 0 ){
                 if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('chat');
                     }
                     $selectform = $this->_formUserSelect;
                 if (!$selectform->isValid($_POST)) {
                        $selectform->setDescription('Attenzione: Seleziona un utente.');
                        return $this->render('chat');	
            }
                $usr = $selectform->getValues();
                $chatlist = $this->_chatModel->getAllChatAdmin($usr);
                $this->view->assign(array('chat'     => $chatlist,
                                          'cliente'  => $usr['username'],
                                          'selected' =>  1));
             }

                if($selected == 1 && $sended == 1  ){
                    
                 $chatform = $this->_formChat;   
                 $selectform = $this->_formUserSelect;
                 
                if (!$chatform->isValid($_POST)) {
                    $this->_helper->redirector('chat');
                }
                
                $currentmsg = $chatform->getValues();
                $this->_chatModel->sendMessage('admin',$currentmsg['currentusr'],$currentmsg);
                $chatlist = $this->_chatModel->getAllChatAdmin($currentmsg['currentusr']);
                
                $this->_helper->redirector('chat');
                }
        $this->view->headTitle('Area Riservata'); 
        }
    
    
    public function SelectUserForm(){
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formUserSelect = new Application_Form_Admin_Chat_selectUser();
        $this->_formUserSelect -> setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'chat',
                            'selected' => 1,
                            ),
                            'default'
                            ));
        return $this->_formUserSelect;
    }
    
    private function sendChatForm(){
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formChat = new Application_Form_User_Chat_Message();
            $this->_formChat -> setAction($urlHelper->url(array(
                            'controller' => 'admin',
                            'action' => 'chat',
                            'sended' => 1,
                            'selected' => 1,
                            ),
                            'default'
                            ));
            return $this->_formChat;
    }
    
    
    
    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
}