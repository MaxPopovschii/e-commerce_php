<?php

class SocialUser
{
    public $id;
    public $provider;
    public $provider_id;
    public $username;
    public $email;

    public function __construct($id, $provider, $provider_id, $username, $email)
    {
        $this->id = $id;
        $this->provider = $provider;
        $this->provider_id = $provider_id;
        $this->username = $username;
        $this->email = $email;
    }
}