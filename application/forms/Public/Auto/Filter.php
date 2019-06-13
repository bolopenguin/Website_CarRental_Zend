<?php

class Application_Form_Public_Auto_Filter extends App_Filter_Abstract {

    public function init() {
        $this->setMethod('post');
        $this->setName('filterAuto');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'pricemin', array(
            'label' => 'Prezzo Min',
            'required' => false,
            'filters' => array('LocalizedToNormalized'),
            'validators' => array(array('Float', true, array('locale' => 'en_US'))),
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'pricemax', array(
            'label' => 'Prezzo Max',
            'required' => false,
            'filters' => array('LocalizedToNormalized'),
            'validators' => array(array('Float', true, array('locale' => 'en_US'))),
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'numposti', array(
            'label' => 'Numero posti',
            'required' => false,
            'decorators' => $this->elementDecorators,
            'validators' => array(array('Int', true , array('locale' => 'en_US')))
        ));

        $this->addElement('submit', 'search', array(
            'label' => 'Ricerca',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'filtertable')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

}
