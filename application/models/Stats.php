<?php

class Application_Model_Stats extends App_Model_Abstract {

    public function __construct() {
        
    }

    public function getStatsMonth($mese, $anno) {
        return $this->getResource('Prenotazione')->getStatsMonth($mese, $anno);
    }

}
