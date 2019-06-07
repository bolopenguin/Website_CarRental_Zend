<?php

class Application_Form_Admin_Crudstaff_Inserisci extends App_Form_Abstract {

    public function init() {
        $this->setMethod('post');
        $this->setName('addStaff');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'username', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required' => true,
            'label' => 'Username',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('password', 'password', array(
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
            'label' => 'Cognome',
            'required' => true,
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

        $this->addElement('submit', 'inserisci', array(
            'label' => 'Inserisci',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

}