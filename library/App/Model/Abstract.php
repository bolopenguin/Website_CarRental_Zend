<?php

abstract class App_Model_Abstract {

    protected $_resources = array();

    //array vuoto inizializzato

    public function getResource($name) {
        //questa funzione vede se l'oggetto associtao alla risorsa è stato creato (allora lo ritorna al chiamante) 
        //altrimenti lo crea
        if (!isset($this->_resources[$name])) {
            $class = implode('_', array(
                //implode prende un carattere e un array, crea una stringa con i valori che gli passo nell'array separati
                //dal carattere che gli passo come primo elemento
                $this->_getNamespace(),
                'Resource',
                $name));
            $this->_resources[$name] = new $class();
        }
        return $this->_resources[$name];
    }

    private function _getNamespace() {
        $ns = explode('_', get_class($this));
        return $ns[0];
    }

    public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
        if (!($where instanceof Zend_Db_Table_Select)) {
            $select = $this->select();
            if ($where !== null) {
                $this->_where($select, $where);
            }
            if ($order !== null) {
                $this->_order($select, $order);
            }
            if ($count !== null || $offset !== null) {
                $select->limit($count, $offset);
            }
        } else {
            $select = $where;
        }
        $rows = $this->_fetch($select);
        $data = array(
            'table' => $this,
            'data' => $rows,
            'readOnly' => $select->isReadOnly(),
            'rowClass' => $this->getRowClass(),
            'stored' => true
        );
        $rowsetClass = $this->getRowsetClass();
        if (!class_exists($rowsetClass)) {
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass($rowsetClass);
        }
        return new $rowsetClass($data);
    }

}
