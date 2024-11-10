<?php
class Product
{
    protected $id;
    protected $name;
    protected $price;
    protected $stock;

    public function __construct($id = null, $name = null, $price = null, $stock = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    // Example method to decrement stock
    public function decrementStock()
    {
        if ($this->stock > 0) {
            $this->stock--;
        } else {
            throw new Exception("Stock cannot be negative.");
        }
    }
}
