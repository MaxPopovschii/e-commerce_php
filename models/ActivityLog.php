<?php

class ActivityLog
{
    public $id;
    public $user_id;
    public $action;
    public $details;
    public $created_at;

    public function __construct($id, $user_id, $action, $details, $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->action = $action;
        $this->details = $details;
        $this->created_at = $created_at;
    }
}