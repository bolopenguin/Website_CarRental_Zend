<?php

class Application_Model_Chat extends App_Model_Abstract {

    public function __construct() {
    }

    public function sendMessage($sender,$receiver,$currentmsg){
        return $this->getResource('Chat')->sendMessage($sender,$receiver,$currentmsg);
    }

    public function getAllChatUser($usr){
        return $this->getResource('Chat')->getAllChatUser($usr);
    }
    
     public function getAllChatAdmin($usr){
        return $this->getResource('Chat')->getAllChatAdmin($usr);
    }
    
    }