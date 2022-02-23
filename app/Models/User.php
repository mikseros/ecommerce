<?php
namespace App\Models;

class User {
    protected $id;
    protected $mail;
    protected $password;

    // Get Methods
    public function getId()
    {
        return $this->id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // Set Methods
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    // CRUD operations
    public function create(array $data)
    {

    }

    public function read(int $id)
    {

    }

    public function update(int $id, array $data)
    {

    }

    public function delete(int $id)
    {
        
    }
}