<?php

class User{
    private $id;
    private $name;
    private $surname;
    private $mail;
    private $password;
    private $admin;
    private $seller;

    public function __construct($id, $name, $surname, $mail, $password, $admin, $seller)
    {
        $this->id = htmlspecialchars($id);
        $this->name = htmlspecialchars($name);
        $this->surname = htmlspecialchars($surname);
		$this->mail = htmlspecialchars($mail);
		if ($password == '') {
			$this->password = '';
		} else {
			$this->password = password_hash($password, PASSWORD_DEFAULT);
		}
        $this->admin = htmlspecialchars($admin);
        $this->seller = htmlspecialchars($seller);
    }

    public function getId()
    {
        return htmlspecialchars($this->id);
    }
    public function setId($id)
    {
        $this->id = htmlspecialchars($id);
        return $this;
    }

    public function getMail(){
        return htmlspecialchars($this->mail);
    }
    public function setMail($mail){
        $this->mail = htmlspecialchars($mail);
        return $this;
    }

    public function getSurname(){
        return htmlspecialchars($this->surname);
    }
    public function setSurname($surname){
        $this->surname = htmlspecialchars($surname);
        return $this;
    }

    public function getName(){
        return htmlspecialchars($this->name);
    }
    public function setName($name){
        $this->name = htmlspecialchars($name);
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getAdmin()
    {
        return $this->admin;
    }
    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    public function getSeller()
    {
        return $this->seller;
    }
    public function setSeller($seller)
    {
        $this->seller = $seller;
        return $this;
    }
}
