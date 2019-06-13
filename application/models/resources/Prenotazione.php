<?php

class Application_Resource_Prenotazione extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione';
    protected $_primary  = array ('targa', 'username', 'data_inizio');
    protected $_rowClass = 'Application_Resource_Prenotazione_Item';
    
    public function init()
    {            
    }
    
    public function getStatsYear(){
        $stats = array();
        $anno = date('Y');
        
        for( $i=1;  $i <=12 ; $i++  ){
        $data_inizio= date("Y-m-d", strtotime($anno."-".$i."-01"));
        $data_fine= date("Y-m-d", strtotime($anno."-".$i."-31"));
            
        $select = $this->select()
                ->from('prenotazione', array('num'=>'COUNT(*)'))
                ->where('data_inizio >=?', $data_inizio)
                ->where('data_inizio <=?', $data_fine);

        $result = $this->fetchRow($select);
        $stats[$i] = $result["num"];          
        }
        
        return $stats;       
    }
    
    public function getStatsMonth($mese){
        $anno = date('Y');
        $data_inizio= date("Y-m-d", strtotime($anno."-".$mese."-01"));
        $data_fine= date("Y-m-d", strtotime($anno."-".$mese."-31"));
        
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('auto')
                ->joinLeft(array('prenota'=>'prenotazione'),'auto.targa = prenota.targa')
                ->where('prenota.data_inizio >=?', $data_inizio)
                ->where('prenota.data_inizio <=?', $data_fine);  
        
        return $this->fetchAll($select);       
    }
    
    public function getNotAvaiableAuto($periodo){
        
        $inizio = $periodo['inizio'];
        $fine   = $periodo['fine'];
                     
        $start = date('Y-m-d',strtotime($inizio));
        $end = date('Y-m-d',strtotime($fine));
        $select = $this-> select('targa') 
                -> where('data_fine > ?', $start )
                -> where('data_inizio < ?', $end);
                                       
        return $this->fetchAll($select);
    }
    
    public function getPrenotazioni($username){
        $select = $this-> select() 
                -> where('username =?', $username);
                                       
        return $this->fetchAll($select);
    }
    
       public function addOrder($order){
       $this->insert($order);
   }
   

   
}
