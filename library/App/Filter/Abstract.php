<?php
class App_Filter_Abstract extends Zend_Form
{
	public $elementDecorators = array(
        'ViewHelper',
        array(array('alias1' => 'HtmlTag'),array('tag' => 'td')),
        array('Label', array('tag' => 'td')),
        array(array('alias4' => 'HtmlTag'), array('tag' => 'td')),
        );
        
        public $buttonDecorators = array(
        'ViewHelper',
        array(array('alias1' => 'HtmlTag'), array('tag' => 'td')),
        array(array('alias2' => 'HtmlTag'), array('tag' => 'td')),
    	);
}

