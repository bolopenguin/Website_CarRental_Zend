<?php

class Application_Form_User_Chat_Message extends App_Form_Abstract {

protected $_chatModel;


    public function init() {
        $this->_chatModel = new Application_Model_Chat();


        $this->setMethod('post');
        $this->setName('messageForm');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

              
         $this->addElement('textarea', 'message', array(
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        ));
         
         $this->addElement('hidden', 'currentusr', array(
            'required' => false,
            'value' => null,
            'decorators' => $this->elementDecorators,
        ));
         
        $this->addElement('submit', 'send', array(
            'label' => 'invia',
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
