<?php
namespace App\Models;

class Article {

    protected $id;
    protected $title;
    protected $text;

    // Get Methods
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    // Set Methods
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setText(string $text)
    {
        $this->text = $text;
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