<?php

class Application_Form_Admin_Crudfaq_Modifica extends App_Form_Abstract {

    protected $_faqModel;

    public function init() {
        $this->_faqModel = new Application_Model_Questions();
        $this->setMethod('post');
        $this->setName('modifyFaq');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        
        $this->addElement('text', 'domanda', array(
            'validators' => array(
                array('StringLength', true, array(0, 200))
            ),
            'required' => true,
            'label' => 'Domanda',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('textarea', 'risposta', array(
            'required' => true,
            'label' => 'Risposta',
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('hidden', 'id', array(
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

    public function populate($id) {
        $faq = $this->_faqModel->getFaqById($id);

        $this->id->setValue($faq['id']);
        $this->domanda->setValue($faq['domanda']);
        $this->risposta->setValue($faq['risposta']);

        return $this;
    }

}