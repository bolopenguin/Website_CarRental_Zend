<?php

class Application_Resource_Auto extends Zend_Db_Table_Abstract
{
    protected $_name    = 'auto';
    protected $_primary  = 'targa';
    protected $_rowClass = 'Application_Resource_Auto_Item';
    
    public function init()
    {            
    }
    
    public function getAllAuto($paged=null){
        
        $select = $this->select()->order('targa') ;
                                    
        if($paged !== null){
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(3)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
        }
        return $this->fetchAll($select);
        
    }
    
   
}