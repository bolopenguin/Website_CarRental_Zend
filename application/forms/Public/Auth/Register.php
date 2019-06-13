<?php

class Application_Form_Public_Auth_Register extends App_Form_Abstract {

    public function init() {
        $this->setMethod('post');
        $this->setName('register');
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
            'required' => true,
            'label' => 'Cognome',
            'decorators' => $this->elementDecorators,
        ));
                        
        $this->addElement('text', 'residenza', array(
            'validators' => array(
                array('StringLength', true, array(1, 20))
            ),
            'required' => true,
            'label' => 'Città di Residenza',
            'decorators' => $this->elementDecorators,
        ));
                                
        $this->addElement('select', 'occupazione', array(
            'required' => true,
            'label' => 'Occupazione',
            'multiOptions' => array('studente' => 'studente', 'professore'=> 'professore', 'impiegato'=>'impiegato', 'imprenditore'=>'imprenditore', 'operaio'=>'operaio', 'altro'=>'altro'),
            'decorators' => $this->elementDecorators,
        ));
                                        
        $this->addElement('text', 'data_nascita', array(
            'required' => true,
            'label' => 'Data di Nascita',
            'validators' => array(array('Date', true, array('format' => 'Y-m-d'))),
            'filters' => array('LocalizedToNormalized'),
            'placeholder' => 'aaaa-mm-gg',
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('hidden', 'role', array(
            'required' => false,
            'value' => 'user',
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('submit', 'register', array(
            'label' => 'Registrati',
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