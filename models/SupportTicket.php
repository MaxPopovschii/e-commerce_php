<?php

class SupportTicket
{
    public $id;
    public $user_id;
    public $subject;
    public $message;
    public $status;
    public $created_at;

    public function __construct($id, $user_id, $subject, $message, $status, $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->subject = $subject;
        $this->message = $message;
        $this->status = $status;
        $this->created_at = $created_at;
    }
}