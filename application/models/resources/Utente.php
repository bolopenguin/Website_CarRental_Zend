<?php

class Application_Resource_Utente extends Zend_Db_Table_Abstract {

    protected $_name = 'utente';
    protected $_primary = 'username';
    protected $_rowClass = 'Application_Resource_Utente_Item';

    public function init() {
        
    }

    public function getUserByName($usrName) {
        //$usrName è lo username che ci viene fornito dalla form
        return $this->fetchRow($this->select()->where('username = ?', $usrName));
        //fetchRow tira fuori la prima righa che matcha con quello che gli dico, in questo caso usrName
    }

}
