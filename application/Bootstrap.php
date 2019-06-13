<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected $_view;


    protected function _initDatabase(){
        include_once ( APPLICATION_PATH.'/../../include/connect.php');
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host' => $HOST ,
            'username' => $USER,
            'password' => $PASSWORD,
            'dbname' => $DB,
        ));
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
    
    protected function _initRequest()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }

    protected function _initViewSettings()
    {
        
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->setCharset('UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/styles.css'));
    }
    
        protected function _initDefaultModuleAutoloader() {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('App_');
        $this->getResourceLoader()
                ->addResourceType('modelResource', 'models/resources', 'Resource');
    }
    
     protected function _initFrontControllerPlugin()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$front->registerPlugin(new App_Controller_Plugin_Acl());
    }
}

