<?php 
class Entreprise{
    private $id;
    private $owner;
    private $name;
    private $address;
    private $city;
    private $product;
    private $phone;

    public function __construct($owner, $name, $address, $city, $product, $phone) {
        $this->owner = $owner;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->product = $product;
        $this->phone = $phone;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    public function getName()
    {
        return htmlspecialchars($this->name);
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress()
    {
        return htmlspecialchars($this->address);
    }
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }


    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function getProduct()
    {
        return htmlspecialchars($this->product);
    }

    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    public function getPhone()
    {
        return htmlspecialchars($this->phone);
    }


    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
