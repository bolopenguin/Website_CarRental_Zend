<?php

class Application_Form_User_Auto_Filter extends App_Filter_Abstract {

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
             'validators' => array(array('Int', true, array('locale' => 'en_US'))),
            'decorators' => $this->elementDecorators,
        ));

        
         $this->addElement('text','inizio', array(
            'label' => 'Data Inizio',
            'placeholder' => 'aaaa-mm-gg',
            'validators' => array(array('Date', true, array('format' => "Y-m-d"))),
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->SecondRowDecorators,
        ));

        $this->addElement('text', 'fine', array(
            'label' => 'Data Fine',
            'placeholder' => 'aaaa-mm-gg',
            'validators' => array(array('Date', true, array('format' => "Y-m-d"))),
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->SecondRowDecorators,
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
