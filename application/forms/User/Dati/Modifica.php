<?php
class Application_Form_User_Dati_Modifica extends App_Form_Abstract
{
        protected $_userModel;
                
	public function init()
	{
                $this->_userModel = new Application_Model_User;
                $this->setMethod('post');
		$this->setName('modificaprofilo');
		$this->setAction('');
		$this->setAttrib('enctype', 'multipart/form-data');
        
            $this->addElement('text', 'username', array(
            'label' => 'Username',
            'required' => false,
            'readonly' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
                    
            $this->addElement('text', 'role', array(
            'label' => 'role',
            'required' => false,
            'readonly' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            
            $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => false,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => false,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            $this->addElement('text', 'residenza', array(
            'label' => 'Città',
            'required' => false,
                'decorators' => $this->elementDecorators,
        		));
            

            
            $this->addElement('text', 'password', array(
            'label' => 'Nuova Password',
            'required' => false,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            $this->addElement('submit', 'add', array(
            'label' => 'Applica',
                'decorators' => $this->buttonDecorators,
                ));
       $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table', 'class' => 'filtertable')),
			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
			'Form'
		));
        }
        
        public function populate($dato)
    {
        $utente = $this->_userModel->getUserByName($dato);
        
        $this->username->setValue($utente['username']);   
        $this->nome->setValue($utente['nome']);   
        $this->role->setValue($utente['role']);   
        $this->cognome->setValue($utente['cognome']);
        $this->residenza->setValue($utente['residenza']);
        $this->password->setValue($utente['password']);


        return $this;
    }
}
