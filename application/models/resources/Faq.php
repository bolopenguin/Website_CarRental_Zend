<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract
{
    protected $_name    = 'faq';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Faq_Item';
    
    public function init()
    {            
    }
    
    public function getFaqById($id){
        $select = $this->select()
            ->where('id =?', $id);
        
        return $this->fetchRow($select);
    }
    
    
    public function getAllFaq(){       
        $select = $this->select()->order('id') ;
        return $this->fetchAll($select);       
    }
    
    public function getIdMax(){
        $max=$this->fetchRow($this->select('id')
                             -> order('id DESC'));
        
        return $max;
    }
    
    public function addFaq($values){
        $select = $this->select()
                ->where('id = ?', $values['id']);
        
        $result = $this->fetchRow($select);
        
        if ($result === null) {
            $this->insert($values);
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteFaq($values){
        $id = $values['id'];
        $this->delete(array('id = ?' => $id));
    }
    
    public function modifyFaq($values){
        $this->deleteFaq($values);
        $this->addFaq($values);
    }
}
