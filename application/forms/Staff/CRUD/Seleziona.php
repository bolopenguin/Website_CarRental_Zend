<?php

class Application_Form_Staff_Crud_Seleziona extends App_Form_Abstract {
    
    protected $_catalogModel;
    
    public function init() {
        $this->_catalogModel = new Application_Model_Catalog;
        $this->setMethod('post');
        $this->setName('selectAuto');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('radio', 'targa', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => $this->buildMultiOptions(),
        ));
        
        
        $this->addElement('submit', 'select', array(
            'label' => 'Modifica',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
    
    protected function buildMultiOptions()
    {
        $vetture = $this->_catalogModel->getAllAuto(null);
        $return = array();
        foreach ($vetture as $row) {
            $return[$row['targa']] = $row['targa'];
        }
        return $return;
    }

}

