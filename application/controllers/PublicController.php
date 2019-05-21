<?php
// meccanismi di naming vanno rispettati strettamente
class PublicController extends Zend_Controller_Action {

    protected $_logger;
    // Nel controller sono definite le azioni che a seconda dei parametri del model prendono i dati e li iniettano nella vista
    
    public function init() {
        $this->_helper->layout->setLayout('layout'); //helper layout che definisce l'attivazione del layout all'interno della nostra applicazione
        // setLayout va a recuperare il file main.phtml nella cartella di layout che abbiamo deinito nel file application.ini
        $this->_logger = Zend_Registry::get('log');
    }
    
    public function indexAction(){
        //i dati vengono gestiti dal model, costruiremo una classe "catalog.php" con le proprietà che ci interessano, successivamente
        //inizializzeremo i dati da un DB. Così attiviamo il metodo "getProds" del model per estrarre i prodotti
        $prods = $this->_catalogModel->getProds();
        
    }


    // la viewAction dovrà iniettare il contenuto where o il contenuto who
        // abbiamo formalizato staticPage nel file topnavmain 
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