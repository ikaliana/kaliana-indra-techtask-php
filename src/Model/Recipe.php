<?php
namespace App\Model;

class Recipe
{
    private $title;
    private $ingridients;

    public function getTitle()
    {
        return $this->title;
    }

    public function getIngridients()
    {
        return $this->ingridients;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setIngridients($ingridients)
    {
        $this->ingridients = $ingridients;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }
}