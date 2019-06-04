<?php

class StaffController extends Zend_Controller_Action {
    
    
    protected $_formAdd;
    protected $_formDelete;
    protected $_formSelect;
    protected $_formModify;
    protected $_catalogModel;

    public function init() {
        $this->_catalogModel = new Application_Model_Catalog;
        $this->_helper->layout->setLayout('layout');
        $this->_authService = new Application_Service_Auth();
        $this->view->inserisciForm = $this->addAutoForm();
        $this->view->eliminaForm = $this->deleteAutoForm();
        $this->view->selezionaForm = $this->selectAutoForm();
        $this->view->modificaForm = $this->modifyAutoForm();
        $this->_logger = Zend_Registry::get('log');
    }

    public function indexAction() {
        
    }
    
    public function staffareaAction(){
        $param = $this->_getParam('operazione', 'noOp');
        $targa = $this->_getParam('macchina', null);
        if($param === 'elimina'){
            $vetture = $this->_catalogModel->getAllAuto(null);
            $this->view->assign(array('auto' => $vetture));
        }
        $this->view->assign(array('operazione' => $param, 'macchina' => $targa));
        $this->view->headTitle('Area Riservata');
    }
    
    public function addautoAction()	{
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('staffarea');
		}
		$form=$this->_formAdd;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                        $this->view->assign(array('operazione' => 'inserisci'));
                        return $this->render('staffarea');	
		}
		$values = $form->getValues();
		$this->_catalogModel->addAuto($values);
		$this->_helper->redirector('staffarea');
	}

    private function addAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formAdd = new Application_Form_Staff_Crud_Inserisci();
            $this->_formAdd->setAction($urlHelper->url(array(
                            'controller' => 'staff',
                            'action' => 'addauto',
                            ),
                            'default'
                            ));
            return $this->_formAdd;
    }
    
    public function deleteautoAction()	{
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('staffarea');
		}
		$form=$this->_formDelete;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                        $this->view->assign(array('operazione' => 'elimina'));
                        return $this->render('staffarea');	
		}
		$values = $form->getValues();
		$this->_catalogModel->deleteAuto($values);
		$this->_helper->redirector->gotoUrl('/staff/staffarea/operazione/elimina');
	}

    private function deleteAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formDelete = new Application_Form_Staff_Crud_Elimina();
            $this->_formDelete->setAction($urlHelper->url(array(
                            'controller' => 'staff',
                            'action' => 'deleteauto',
                            ),
                            'default'
                            ));
            return $this->_formDelete;
    }
    
    public function selectautoAction()	{
            if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('staffarea');
            }
            $form=$this->_formSelect;
            if (!$form->isValid($_POST)) {
                    $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                    $this->view->assign(array('operazione' => 'seleziona'));
                    return $this->render('staffarea');	
            }
            $values = $form->getValues();
            $this->_logger->info('la targa vale:'.$values['targa']);
            $this->_helper->redirector('staffarea', 'staff', '', array('operazione' => 'modifica', 'macchina' => $values['targa']));
    }

    private function selectAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formSelect = new Application_Form_Staff_Crud_Seleziona();
            $this->_formSelect->setAction($urlHelper->url(array(
                            'controller' => 'staff',
                            'action' => 'selectauto',
                            ),
                            'default'
                            ));
            return $this->_formSelect;
    }
    
        
    public function modifyautoAction()	{
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('staffarea');
		}
		$form=$this->_formModify;
		if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                        $this->view->assign(array('operazione' => 'modifica'));
                        return $this->render('staffarea');	
		}
		$values = $form->getValues();
		$this->_catalogModel->modifyAuto($values);
		$this->_helper->redirector('staffarea');
	}

    private function modifyAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formModify = new Application_Form_Staff_Crud_Modifica();
            $this->_formModify->setAction($urlHelper->url(array(
                            'controller' => 'staff',
                            'action' => 'modifyauto',
                            ),
                            'default'
                            ));
            return $this->_formModify;
    }
    
    public function logoutAction() {
        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');
    }
}