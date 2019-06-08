<?php

class Application_Resource_Utente extends Zend_Db_Table_Abstract {

    protected $_name = 'utente';
    protected $_primary = 'username';
    protected $_rowClass = 'Application_Resource_Utente_Item';

    public function init() {
        
    }

    public function getUserByName($usrName) {
        $select = $this->select()
                ->where('username = ?', $usrName);
        return $this->fetchRow($select);
    }

    public function addUtente($values){
        $select = $this->select()
                ->where('username = ?', $values['username']);
        
        $result = $this->fetchRow($select);
        
        if ($result === null) {
            $this->insert($values);
            return true;
        } else {
            return false;
        }
    }
    
    public function modifyUser($values){
        $username=$values['username'];
        $this->delete(array('username = ?' => $username));
        $this->insert($values);
    }
    
    public function getAllStaff(){
        $select = $this->select()
                ->where('role =?', 'staff')
                ->order('username');
        
        return $this->fetchAll($select);
    }
    
    public function getAllUsers(){
        $select = $this->select()
                ->where('role =?', 'user')
                ->order('username');
        
        return $this->fetchAll($select);
    }
    
    public function deleteUser($values){
        foreach ($values['username'] as $utente){
        $this->delete(array('username = ?' => $utente));
        }
    }
}
