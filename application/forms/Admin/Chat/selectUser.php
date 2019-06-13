<?php

class Application_Form_Admin_Chat_selectUser extends App_Form_Abstract {
    
    protected $_userModel;
    
    public function init() {
        $this->_userModel = new Application_Model_User;
        $this->setMethod('post');
        $this->setName('selectUtente');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('select', 'username', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => $this->buildMultiOptions(),
            'label' => "Username",
        ));
        
        
        $this->addElement('submit', 'scegli', array(
            'label' => 'seleziona',
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
        $users = $this->_userModel->getAllUsers();
        $return = array();
        foreach ($users as $row) {
            $return[$row['username']] = $row['username'];
        }
        return $return;
    }
}