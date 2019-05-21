<?php

class Application_Resource_Auto extends Zend_Db_Table_Abstract
{
    protected $_name    = 'auto';
    protected $_primary  = 'targa';
    protected $_rowClass = 'Application_Resource_Auto';
    
	public function init()
    {
            $select = $this->select()
                    ->where('marca', Fiat);
        
    }
    
   
}