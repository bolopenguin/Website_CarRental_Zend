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
            'label' => username,
            'required' => true,
            'readonly' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            
            $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            $this->addElement('text', 'residenza', array(
            'label' => 'Città',
            'required' => true,
                'decorators' => $this->elementDecorators,
        		));
            

            
            $this->addElement('text', 'password', array(
            'label' => 'Nuova Password',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            $this->addElement('select', 'occupazione', array(
                'required' => true,
                'decorators' => $this->elementDecorators,
                'multiOptions' => array(
                    'studente' => 'studente',
                    'professore' => 'professore',
                    'impiegato' => 'impiegato',
                    'imprenditore' => 'imprenditore',
                    'operaio' => 'operaio',
                    'altro' => 'altro',
                ),
                'label' => "Occupazione",
            ));
               
        
            $this->addElement('hidden', 'data_nascita', array(
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'decorators' => $this->elementDecorators,
        		));
            
            
            $this->addElement('hidden', 'role', array(
            'required' => true,
            'readonly' => true,
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
        $this->data_nascita->setValue($utente['data_nascita']);
        $this->occupazione->setValue($utente['occupazione']);
        
        return $this;
    }
   
}
