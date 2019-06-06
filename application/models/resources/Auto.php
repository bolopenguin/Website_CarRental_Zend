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
        
        $select = $this->select()->order('prezzo_giornaliero') ;
                                    
        if($paged !== null){
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(3)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
        }
        return $this->fetchAll($select);
        
    }
    public function getFilteredAuto($values){
    
        $min=$values['pricemin'];
        $max=$values['pricemax'];
        $posti=$values['numposti'];
        
        $select = $this->select()
                ->where('prezzo_giornaliero >= ?', $min)
                ->where('prezzo_giornaliero <= ?', $max)
                ->where('numero_posti >= ?' , $posti)
                ->order('prezzo_giornaliero');
        
        return $this->fetchAll($select);
        }
        
    public function addAuto($values){
        
        $select = $this->select()
                ->where('targa = ?', $values['targa']);
        
        $result = $this->fetchRow($select);
        
        if ($result === null) {
            $this->insert($values);
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteAuto($values){
        $targa = $values['targa'];
        $this->delete(array('targa = ?' => $targa));
    }
    
    public function getAuto($targa=null){
        
        $select = $this->select()
                ->where('targa =?', $targa) ;
                                    
        return $this->fetchRow($select);
        
    }
    
    public function modifyAuto($values){
        $this->deleteAuto($values);
        $this->addAuto($values);
    }
    
       
    public function getUserFilteredAuto($values,$tmp,$paged=null){
    
        $abs_max=$this->fetchRow($this->select('prezzo_giornaliero')
                                     -> order('prezzo_giornaliero DESC'));
             
        $min=($values['pricemin']);
        $max=$values['pricemax'];
        $posti=$values['numposti'];
        if($min==null) {$min=0;}
                
        if($max==null) {$max=$abs_max['prezzo_giornaliero'];}
        if($posti==null) {$posti=0;} 
        $targhe=array();
        foreach ($tmp as $prenotazione) {
            array_push($targhe, $prenotazione->targa);
        }
        $stringa = "('".implode("','", $targhe)."')";
        
        $select = $this->select()
                ->where('targa NOT IN '.$stringa)
                ->where('prezzo_giornaliero >= ?', $min)
                ->where('prezzo_giornaliero <= ?', $max)
                ->where('numero_posti >= ?' , $posti)
                ->order('prezzo_giornaliero');
        
        if($paged !== null){
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(3)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
        }
        
        return $this->fetchAll($select);
        }
        
        public function getAvaiableAuto($tmp, $paged = null){
        
        $targhe=array();
        foreach ($tmp as $prenotazione) {
            array_push($targhe, $prenotazione->targa);
        }
        $stringa = "('".implode("','", $targhe)."')";
        $select = $this->select()
                                ->where('targa NOT IN '.$stringa)
                                ->order('prezzo_giornaliero') ;
        
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