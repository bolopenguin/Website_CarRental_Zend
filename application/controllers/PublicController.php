<?php
// meccanismi di naming vanno rispettati strettamente
class PublicController extends Zend_Controller_Action {
    
    protected $_questionsModel;
    protected $_catalogModel;
    protected $_logger;
    protected $_form;
    // Nel controller sono definite le azioni che a seconda dei parametri del model prendono i dati e li iniettano nella vista
    
    public function init() {
        $this->_helper->layout->setLayout('layout'); //helper layout che definisce l'attivazione del layout all'interno della nostra applicazione
        // setLayout va a recuperare il file main.phtml nella cartella di layout che abbiamo deinito nel file application.ini
        $this->_logger = Zend_Registry::get('log');
        $this->_catalogModel = new Application_Model_Catalog();
        $this->_questionsModel = new Application_Model_Questions();
        $this->view->filterForm = $this->getAutoForm();
    }
    
    public function indexAction(){
       
    }
    
    
    
    private function getAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_form = new Application_Form_Public_Auto_Filter();
            $this->_form->setAction($urlHelper->url(array(
                            'controller' => 'public',
                            'action' => 'leauto',
                            'search' => '1',
                            ),
                            'default'
                            ));
            return $this->_form;
    }
    
    public function leautoAction(){

    $paged = $this->_getParam('page',1);
    $search = (int)$this->_getParam('search', 0);
    
    if($search === 0){
        
        $vetture = $this->_catalogModel->getAllAuto($paged);
        
    } elseif($search === 1){
        
        if (!$this->getRequest()->isPost()) {             
            $this->_helper->redirector('leauto');
        }
        
        $form=$this->_form;
        
        if (!$form->isValid($_POST)) {
                return $this->render('leauto');
        }
        
        $values = $form->getValues();
        $vetture = $this->_catalogModel->getFilteredAuto($values);
    }
    
    
    $this->view->assign(array('auto' => $vetture));
    $this->view->headTitle('Le Auto');
       
    }

    
    
    
    
    
    
    
    
    
    
    
    
    public function faqAction(){
        $faq = $this->_questionsModel->getAllFaq();
        $this->view->assign(array('faq' => $faq));
        $this->view->headTitle('FAQ');
    }
    public function viewstaticAction() {
        $page = $this->_getParam('staticPage'); 
        if ($page == "servizi") {
            $this->view->headTitle('Servizi');
        } elseif ($page == "chisiamo") {
            $this->view->headTitle('Chi siamo');
        }
       
        $this->render($page);
    }

}