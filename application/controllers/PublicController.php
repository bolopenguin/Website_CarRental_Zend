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
        
        
    }


    // la viewAction dovrà iniettare il contenuto where o il contenuto who
        // abbiamo formalizato staticPage nel file topnavmain 
    public function viewstaticAction() {
        $page = $this->_getParam('staticPage'); //recupera dal request object il parametro che gli passo come parametro della chiamata HTTP (staticpage)
        //viene attivato il controllore public e l'azione viewstatic quando viene chiamato il paramtero 'staticPage'
       
        //$this->view->headLink()->appendStylesheet($this->view->baseUrl('css/chisiamo.css'));
       
        $this->render($page); // $page contiene who o where a seconda della richiesta (where o who sono due viewscritp)
        //render seve per definire quale è la vista che la nostra azione deve utilizzare per produrre il suo output
        //il metodo standard di zend va a prendere il viewscript pippo dell'azione pippo
        //con render invece modifichaimo il default di zend 
        //tramite render inietterà il paramtero staticPage che vale who o where a seconda di quale viene richiesto --> Ecco perchè non ho la view di viewstatic tra gli scripts della view
    }

}