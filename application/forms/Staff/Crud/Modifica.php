<?php

class Application_Form_Staff_Crud_Modifica extends App_Form_Abstract {
    
    protected $_catalogModel;
    
    public function init() {
        $this->_catalogModel = new Application_Model_Catalog;
        $this->setMethod('post');
        $this->setName('addAuto');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');


        $this->addElement('text', 'targa', array(
            'filters' => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array('StringLength', true, array(7, 7))
            ),
            'required' => true,
            'readonly' => true,
            'label' => 'Targa',
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'marca', array(
            'validators' => array(
                array('StringLength', true, array(3, 20))
            ),
            'required' => true,
            'label' => 'Marca',
            'decorators' => $this->elementDecorators,
        ));
        
        
        $this->addElement('text', 'modello', array(
            'validators' => array(
                array('StringLength', true, array(3, 20))
            ),
            'required' => true,
            'label' => 'Modello',
            'decorators' => $this->elementDecorators,
        ));

        
        $this->addElement('text', 'allestimento', array(
            'validators' => array(
                array('StringLength', true, array(3, 20))
            ),
            'required' => true,
            'label' => 'Allestimento',
            'decorators' => $this->elementDecorators,
        ));
        
        
        $this->addElement('file', 'foto', array(
            'label' => 'Foto',
            'destination' => APPLICATION_PATH . '/../public/images/auto',
            'required' => false,
            'validators' => array( 
            array('Count', false, 1),
            array('Extension', false, array('jpg', 'png'))),
            'decorators' => $this->fileDecorators,
            ));
        
        $this->addElement('text', 'prezzo_giornaliero', array(
            'label' => 'Prezzo Giornaliero',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'validators' => array(array('Float', true, array('locale' => 'en_US'))),
            'decorators' => $this->elementDecorators,
		));
        
        $this->addElement('text', 'numero_posti', array(
            'validators' => array(
                array('StringLength', true, array(1, 1))
            ),
            'required' => true,
            'label' => 'Numero Posti',
            'decorators' => $this->elementDecorators,
        ));
        
        
        $this->addElement('submit', 'add', array(
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
    
    public function populate($targa)
    {
        $macchina = $this->_catalogModel->getAuto($targa);
        
        $this->targa->setValue($macchina['targa']);
        $this->marca->setValue($macchina['marca']);  
        $this->modello->setValue($macchina['modello']);
        $this->allestimento->setValue($macchina['allestimento']);
        $this->foto->setValue($macchina['foto']);
        $this->prezzo_giornaliero->setValue($macchina['prezzo_giornaliero']);
        $this->numero_posti->setValue($macchina['numero_posti']);                     
        
        return $this;
    }
}
