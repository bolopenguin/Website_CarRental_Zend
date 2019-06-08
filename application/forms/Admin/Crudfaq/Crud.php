<?php

class Application_Form_Admin_Crudfaq_Crud extends App_Form_Abstract {
    
    protected $_faqModel;
    
    public function init() {
        $this->_faqModel = new Application_Model_Questions();
        $this->setMethod('post');
        $this->setName('crudFaq');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('select', 'id', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => $this->buildMultiOptions(),
            'label' => "ID domanda",
        ));
        
        $this->addElement('radio', 'opzione', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => array('modify' => 'Modifica', 'delete' => 'Elimina'),
        ));
        
        $this->addElement('submit', 'prosegui', array(
            'label' => 'Prosegui',
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
        $utenti = $this->_faqModel->getAllFaq();
        $return = array();
        foreach ($utenti as $row) {
            $return[$row['id']] = $row['id'];
        }
        return $return;
    }

}
