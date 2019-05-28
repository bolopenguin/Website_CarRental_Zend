<?php

class Application_Service_Auth {

    protected $_userModel;
    protected $_auth;

    public function __construct() {
        $this->_userModel = new Application_Model_User();
    }

    public function authenticate($credentials) { //credentials prende i dati di form->getValues
        $adapter = $this->getAuthAdapter($credentials); 
        //connessione tra questo ambiente e la tabella utente nel DB
        $auth = $this->getAuth();
        $result = $auth->authenticate($adapter); //prende di aut una funzione che si chaima authentichtae e gli passa l'adapter

        if (!$result->isValid()) { //se non è valida
            return false;
        }
        
        $user = $this->_userModel->getUserByName($credentials['username']); //utente che volgiamo salvare
        $auth->getStorage()->write($user); //salviamo l'utente per non perdere il login da una pagina all'altra
        return true;
    }

    public function getAuth() { //crea un istanza dell'autorizzazione
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }

    public function getIdentity() {
        $auth = $this->getAuth();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }

    public function clear() {
        $this->getAuth()->clearIdentity();
    }

    private function getAuthAdapter($values) {
        $authAdapter = new Zend_Auth_Adapter_DbTable(
                Zend_Db_Table_Abstract::getDefaultAdapter(), 'utente', 'username', 'password'
                //nometabella, campi username e password
        );
        $authAdapter->setIdentity($values['username']); //setIdentity è standard
        $authAdapter->setCredential($values['password']); // setta l'identità e le credenziali
        return $authAdapter;
    }

}
