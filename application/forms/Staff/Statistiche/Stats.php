<?php

class Application_Form_Staff_Statistiche_Stats extends App_Form_Abstract {

    protected $_statsModel;

    public function init() {
        $this->_statsModel = new Application_Model_Stats;
        $this->setMethod('post');
        $this->setName('statsAuto');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('select', 'mese', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
            'multiOptions' => array(
                '01' => 'Gennaio',
                '02' => 'Febbraio',
                '03' => 'Marzo',
                '05' => 'Maggio',
                '06' => 'Giugno',
            ),
            'label' => "Mese",
        ));


        $this->addElement('submit', 'visualizza', array(
            'label' => 'Visualizza',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

//    protected function buildMultiOptions()
//    {
//        $mesi = $this->_catalogModel->getAllAuto(null);
//        $return = array();
//        foreach ($vetture as $row) {
//            $return[$row['targa']] = $row['targa'];
//        }
//        return $return;
//    }
}
