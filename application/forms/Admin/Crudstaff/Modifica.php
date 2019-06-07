<?php

class Application_Form_Admin_Crudstaff_Modifica extends App_Form_Abstract {

    protected $_userModel;

    public function init() {
        $this->_userModel = new Application_Model_User();
        $this->setMethod('post');
        $this->setName('modifyStaff');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'username', array(
            'readonly' => true,
            'required' => true,
            'label' => 'Username',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'password', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required' => true,
            'label' => 'Password',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'nome', array(
            'validators' => array(
                array('StringLength', true, array(1, 30))
            ),
            'required' => true,
            'label' => 'Nome',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'cognome', array(
            'validators' => array(
                array('StringLength', true, array(1, 30))
            ),
            'required' => true,
            'label' => 'Cognome',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('hidden', 'residenza', array(
            'required' => false,
            'value' => null,
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('hidden', 'role', array(
            'required' => false,
            'value' => 'staff',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('hidden', 'occupazione', array(
            'required' => false,
            'value' => null,
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('hidden', 'data_nascita', array(
            'required' => false,
            'value' => null,
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('submit', 'modifica', array(
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

    public function populate($username) {
        $staff = $this->_userModel->getUserByName($username);

        $this->username->setValue($staff['username']);
        $this->password->setValue($staff['password']);
        $this->nome->setValue($staff['nome']);
        $this->cognome->setValue($staff['cognome']);

        return $this;
    }

}