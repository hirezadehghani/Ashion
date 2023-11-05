<?php

namespace app\core;

class Session
{
    protected $session_id;

    public function __construct()
    {
        session_start();
        $this->session_id = session_id();
    }

    public function getSessionId(): string
    {
        return $this->session_id;
    }

    
}
