<?php
namespace App\Model;

class Ingridients {
    private $ingredients;

    public function getIngridients()
    {
        return $this->ingredients;
    }

    // Setters
    public function setIngridients($ingridients)
    {
        $this->ingredients = $ingridients;
    }
}

class Ingridient
{
    private $title;
    private $bestBefore;
    private $useBy;

    // Getters
    public function getTitle()
    {
        return $this->title;
    }

    public function getBestBefore()
    {
        return $this->bestBefore;
    }

    public function getUseBy()
    {
        return $this->useBy;
    }

    // Setters
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setBestBefore($bestBefore)
    {
        $this->bestBefore = $bestBefore;
    }

    public function setUseBy($useBy)
    {
        $this->useBy = $useBy;
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