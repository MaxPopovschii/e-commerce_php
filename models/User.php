<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($id, $username, $email, $password, $role = 'user')
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public static function allFromFile($filepath)
    {
        if (!file_exists($filepath)) return [];
        $json = file_get_contents($filepath);
        $data = json_decode($json, true) ?? [];
        $users = [];
        foreach ($data as $row) {
            $users[] = new User($row['id'], $row['username'], $row['email'], $row['password'], $row['role']);
        }
        return $users;
    }

    public static function saveAllToFile($filepath, $users)
    {
        $data = [];
        foreach ($users as $u) {
            $data[] = [
                'id' => $u->id,
                'username' => $u->username,
                'email' => $u->email,
                'password' => $u->password,
                'role' => $u->role
            ];
        }
        file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
    }
}