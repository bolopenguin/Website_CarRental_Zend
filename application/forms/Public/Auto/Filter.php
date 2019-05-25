<?php
class Application_Form_Public_Auto_Filter extends Zend_Form
{

	public function init()
	{
                $this->setMethod('post');
		$this->setName('filterAuto');
		$this->setAction('');
		$this->setAttrib('enctype', 'multipart/form-data');
        
            $this->addElement('text', 'pricemin', array(
            'label' => 'Prezzo Min',
            'required' => false
        		));
            
            $this->addElement('text', 'pricemax', array(
            'label' => 'Prezzo Max',
            'required' => false
        		));
            
            $this->addElement('text', 'numposti', array(
            'label' => 'Numero posti',
            'required' => false
        		));
            
            $this->addElement('submit', 'search', array(
            'label' => 'Fatto'
                ));
                
        }
}