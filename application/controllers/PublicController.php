<?php
// meccanismi di naming vanno rispettati strettamente
class PublicController extends Zend_Controller_Action {
    
    protected $_questionsModel;
    protected $_catalogModel;
    protected $_userModel;
    protected $_logger;
    protected $_formLogin;
    protected $_formFilter;
    protected $_formRegister;
    protected $_authService;
    // Nel controller sono definite le azioni che a seconda dei parametri del model prendono i dati e li iniettano nella vista
    
    public function init() {
        $this->_helper->layout->setLayout('layout'); //helper layout che definisce l'attivazione del layout all'interno della nostra applicazione
        // setLayout va a recuperare il file main.phtml nella cartella di layout che abbiamo deinito nel file application.ini
        $this->_logger = Zend_Registry::get('log');
        $this->_catalogModel = new Application_Model_Catalog();
        $this->_questionsModel = new Application_Model_Questions();
        $this->_userModel = new Application_Model_User();
        $this->view->filterForm = $this->getAutoForm();
        $this->view->loginForm = $this->getLoginForm();
        $this->view->registerForm = $this->getRegisterForm();
        $this->_authService = new Application_Service_Auth();
    }
    
    public function indexAction(){
       
    }
    
    private function getAutoForm()
    {
            $urlHelper = $this->_helper->getHelper('url');
            $this->_formFilter = new Application_Form_Public_Auto_Filter();
            $this->_formFilter->setAction($urlHelper->url(array(
                            'controller' => 'public',
                            'action' => 'leauto',
                            'search' => '1',
                            ),
                            'default'
                            ));
            return $this->_formFilter;
    }
    
    public function leautoAction(){

    $search = (int)$this->_getParam('search', 0);
    $paged = $this->_getParam('page',1);
    
    if($search === 0){
        
        $vetture = $this->_catalogModel->getAllAuto($paged);
        
    } elseif($search === 1){
        
        if (!$this->getRequest()->isPost()) {             
            $this->_helper->redirector('leauto');
        }
        
        $form=$this->_formFilter;
        
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                return $this->render('leauto');
        }
        
        $values = $form->getValues();
        $vetture = $this->_catalogModel->getFilteredAuto($values,$paged);
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
    
    public function loginAction() {
        
   }
    
    public function authenticateAction() {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $form = $this->_formLogin;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('login');
        }
        if (false === $this->_authService->authenticate($form->getValues())) {
            //authenticate è nel file Auth.php in services
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        return $this->_helper->redirector('index', 'public');
    }

    private function getLoginForm() {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formLogin = new Application_Form_Public_Auth_Login();
        $this->_formLogin->setAction($urlHelper->url(array(
                    'controller' => 'public',
                    'action' => 'authenticate'), 'default'
        ));
        return $this->_formLogin;
    }
    
    public function validateloginAction() {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $loginform = new Application_Form_Public_Auth_Login();
        $response = $loginform->processAjax($_POST);
        if ($response !== null) {
            $this->getResponse()->setHeader('Content-type', 'application/json')->setBody($response);
        }
    }

    public function registerAction() {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $form = $this->_formRegister;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('login');
        }
        $values = $form->getValues();
        $this->_userModel->addUtente($values);
        $this->_helper->redirector('login');
    }

    private function getRegisterForm() {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formRegister = new Application_Form_Public_Auth_Register();
        $this->_formRegister->setAction($urlHelper->url(array(
                    'controller' => 'public',
                    'action' => 'register'), 'default'
        ));
        return $this->_formRegister;
    }
}