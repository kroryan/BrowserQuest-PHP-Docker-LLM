<?php
namespace Server\Messages;

class Talk extends Message
{
    public $npcId;
    
    public function __construct($npcId)
    {
        parent::__construct();
        $this->type = TYPES_MESSAGES_TALK;
        $this->npcId = $npcId;
    }
    
    public function serialize()
    {
        return [
            $this->type,
            $this->npcId
        ];
    }
}