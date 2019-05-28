<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
//(Preso da ZP1)
{
        protected $_logger;
	protected $_view;

    protected function _initLogging()
    {
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/data/log/logFile.log');//definiamo come paramtero il path che verrà utilizzato come log, definiamo come output del log il file logFile.log contenuto nella cartella log contnuta in data contenuta in application    
        $logger = new Zend_Log($writer);//componente per creare messaggi di log

        Zend_Registry::set('log', $logger);

        $this->_logger = $logger;
//    	$this->_logger->info('Bootstrap ' . __METHOD__);
    	$logger->info('Bootstrap ' . __METHOD__);    }

    protected function _initRequest()
	// Aggiunge un'istanza di Zend_Controller_Request_Http nel Front_Controller
	// che permette di utilizzare l'helper baseUrl() nel Bootstrap.php
	// Necessario solo se la Document-root di Apache non è la cartella public (IMPORTANTE)/
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }

    protected function _initViewSettings()
            
            //definiamo i valori dei placeholder del layout
    {
        
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->setCharset('UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/styles.css'));
    }
    
        protected function _initDefaultModuleAutoloader() {
        //meccanismo che aggiunge delle regole a quelle di base
        $loader = Zend_Loader_Autoloader::getInstance();
        //recuperiamo l'Autoloader con getInstance, che è un singleton
        $loader->registerNamespace('App_');
        //registerNamespace definisce che un file si trova nel path indicato nel suo nome
        //es. App_Model_Abstract si troverà in library/app/model
        //così facendo zend saprà dove cercare i file che cominciano il proprio nome con "App_"
        $this->getResourceLoader()
                ->addResourceType('modelResource', 'models/resources', 'Resource');
        //collassiamo in path "/model/resources" in "/Resource"
        //addResourceType con primo paramtero la risorsa che voglio rimappare, secondo parametro la mappatura attuale,
        //terzo parametro la mappatura che voglio ottenere
    }
    
     protected function _initFrontControllerPlugin()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$front->registerPlugin(new App_Controller_Plugin_Acl());
    }
}

