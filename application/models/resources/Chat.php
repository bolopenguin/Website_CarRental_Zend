<?php

class Application_Resource_Chat extends Zend_Db_Table_Abstract
{
    protected $_name    = 'chat';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Chat_Item';
    

    public function init()
    {            
    }
    
    public function sendMessage($sender,$receiver,$currentmsg){
        $msg = $currentmsg['message'];
        $new=array('sender' => $sender, 'receiver' =>$receiver, 'msg' => $msg);
        $this->insert($new);
        
    }

    public function getAllChatUser($usr){
    $select = $this->select()->orWhere('sender = ?',$usr)
                             ->orWhere('receiver = ?', $usr)
                             ->order('id');

    return $this->fetchAll($select);
        
    }
    
    public function getAllChatAdmin($usr){
    $select = $this->select()->orWhere('sender = ?',$usr['username'] )
                             ->orWhere('receiver = ?', $usr['username'])
                             ->order('id');

    return $this->fetchAll($select);
        
    }
    
}