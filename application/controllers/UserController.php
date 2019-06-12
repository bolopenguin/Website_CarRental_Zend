<?php

class UserController extends Zend_Controller_Action {
    
    protected $_catalogModel;
    protected $_userModel;
    protected $_form;
    protected $_logger;
    protected $_modificaForm;
     
     
    public function init() {
        $this->_logger = Zend_Registry::get('log');


        $this->_helper->layout->setLayout('layout');
        $this->view->filterForm = $this->getAutoForm();
        $this->view->modificaForm = $this->getModificaForm();
        $this->_authService = new Application_Service_Auth();
        $this->_catalogModel = new Application_Model_Catalog();
        $this->_userModel = new Application_Model_User();
        
    }

    public function indexAction() {
        
    }
    
     private function getAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_form = new Application_Form_User_Auto_Filter();
            $this->_form -> setAction($urlHelper->url(array(
                            'controller' => 'user',
                            'action' => 'leauto',
                            'search' => '1',
                            ),
                            'default'
                            ));
            return $this->_form;
    }
    
    public function leautoAction(){

    $search = (int)$this->_getParam('search', 0);
    $paged = $this->_getParam('page',1);
                
                
        
    if($search === 0){
        
       $this->view->assign(array('empty' => 'yes')); 
       $vetture = $this->_catalogModel->getAllAuto($paged);
       $this->view->assign(array('auto' => $vetture));
    
    } elseif($search === 1){
        
        if (!$this->getRequest()->isPost()) {             
            $this->_helper->redirector('leauto');
        }
        $form1=$this->_form;
        
        if (!$form1->isValid($_POST)) {
            $form1->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                return $this->render('leauto');
        }
        
        $values = $form1->getValues();
        $tmp = $this->_catalogModel->getNotAvaiableAuto($values);
        $vetture = $this->_catalogModel->getUserFilteredAuto($values,$tmp,$paged);
        $this->view->assign(array('auto' => $vetture,
                                  'datainizio' => $values['inizio'],
                                  'datafine'   => $values['fine'],
                    
                ));
    }  
    $this->view->headTitle('Le Auto');
       
    }


    public function addorderAction(){
        $neworder=array(
        'username' => $this->_getParam('usr'),
        'data_inizio' => $this->_getParam('inizio'),
        'data_fine' => $this->_getParam('fine'),
        'targa' => $this->_getParam('targa'),);
        $this->_catalogModel->addOrder($neworder);
        $this ->render('gestioneprofilo');
    }

    
    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }

    
    public function gestioneprofiloAction(){
        $username = $this->_getParam('username');
        $utente = $this->_userModel->getUserByName($username);
        $prenotazioni = $this->_userModel->getPrenotazioni($username);
        $this->view->assign(array('prenotazioni' => $prenotazioni));
        $this->view->assign(array('utente' => $utente)); 
        $this->view->headTitle('Area Riservata');
    }
    
    public function modificaAction(){
                if (!$this->getRequest()->isPost()) {
                $this->_helper->redirector('gestioneprofilo');
		}
		$form=$this->_modificaForm;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: la modifica non è andata a buon fine. Riprovare');
                        return $this->render('gestioneprofilo');	
		}
		$values = $form->getValues();
		$this->_userModel->modifyUser($values);
                $this->_helper->redirector('gestioneprofilo', 'user', '', array('username' => $values['username']));
	
    }
    
    private function getModificaForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_modificaForm = new Application_Form_User_Dati_Modifica();
            $this->_modificaForm->setAction($urlHelper->url(array(
                            'controller' => 'user',
                            'action' => 'modifica',
                            ),
                            'default'
                            ));
            return $this->_modificaForm;
    }

}

