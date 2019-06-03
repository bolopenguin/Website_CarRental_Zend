<?php

class Application_Form_Staff_Crud_Elimina extends App_Form_Abstract {
    
    public function init() {
        $this->setMethod('post');
        $this->setName('deleteAuto');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'targa', array(
            'filters' => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array('StringLength', true, array(7, 7))
            ),
            'required' => true,
            'label' => 'Targa',
            'decorators' => $this->elementDecorators,
        ));
        
        
        $this->addElement('submit', 'add', array(
            'label' => 'Elimina',
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
