<?php

class Application_Resource_Prenotazione extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione';
    protected $_primary  = array ('targa', 'username');
    protected $_rowClass = 'Application_Resource_Prenotazione_Item';
    
    public function init()
    {            
    }
    
    public function getStatsMonth($mese, $anno){     
        $data_inizio= date("Y-m-d", strtotime($anno."-".$mese."-01"));
        $data_fine= date("Y-m-d", strtotime($anno."-".$mese."31"));

        $select = $this->select('targa')
                ->where('data_inizio =?', "".$anno."-".$mese."23");
        
        return $this->fetchAll($select);       
    }
    
   
}
