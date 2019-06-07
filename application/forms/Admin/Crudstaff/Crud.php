<?php

class Application_Form_Admin_Crudstaff_Crud extends App_Form_Abstract {
    
    protected $_userModel;
    
    public function init() {
        $this->_userModel = new Application_Model_User;
        $this->setMethod('post');
        $this->setName('deleteStaff');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('select', 'username', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => $this->buildMultiOptions(),
            'label' => "Username",
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
        $utenti = $this->_userModel->getAllStaff();
        $return = array();
        foreach ($utenti as $row) {
            $return[$row['username']] = $row['username'];
        }
        return $return;
    }

}
