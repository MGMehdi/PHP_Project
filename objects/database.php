<?php
require_once 'user.php';
require_once 'entreprise.php';
require_once 'city.php';

class Database
{
    private static $dsn = 'mysql:dbname=php;host=127.0.0.1';
    private static $dbUser = 'toto';
    private static $dbPassword = 'Test123*';
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(self::$dsn, self::$dbUser, self::$dbPassword);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function login($mail, $pass)
    {
        $sql = $this->db->prepare('SELECT * FROM `users` WHERE `mail`=?');
        $sql->execute(array($mail));
        while ($row = $sql->fetch()) {
            if (password_verify($pass, $row['password'])) {
                return $user = new User($row['id'], $row['name'], $row['surname'], $row['mail'], $row['password'], $row['isadmin'], $row['isseller']);
            } else {
                return $user = '';
            }
        }
    }

    public function addUser($user)
    {
        try {
            $sql = $this->db->prepare('INSERT INTO `users` (`name`, `surname`, `mail`, `password`) VALUES ( ?, ?, ?, ?)');
            $sql->execute(array($user->getName(), $user->getSurname(), $user->getMail(), $user->getPassword()));
            $user->setPassword('');
            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateUser($user)
    {
        $sql = $this->db->prepare('UPDATE `users` SET `isseller`=1 WHERE id=?');
        $sql->execute(array($user->getId()));
        return true;
    }

    /*****************************************************************************************************************/

    public function GetAllCities()
    {
        $cities = array();
        $sql = $this->db->prepare('SELECT * FROM `location`');
        $sql->execute();
        while ($row = $sql->fetch()) {
            $city = new City($row['city'], $row['province']);
            $city->setId($row['id']);
            array_push($cities, $city);
        }
        return $cities;
    }

    public function GetOneCity($id)
    {
        $sql = $this->db->prepare('SELECT * FROM `location` WHERE `id`=?');
        $sql->execute(array($id));
        while ($row = $sql->fetch()) {
            $city = new City($row['city'], $row['province']);
            $city->setId($row['id']);
        }
        return $city;
    }

    /*****************************************************************************************************************/

    public function GetMyEntreprises($id)
    {
        $entreprises = array();
        $sql = $this->db->prepare('SELECT * FROM `entreprises` WHERE id=?');
        $sql->execute(array($id));
        print_r($sql->errorInfo());

        while ($row = $sql->fetch()) {
            $entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
            array_push($entreprises, $entreprise);
        }
        return $entreprises;
    }

    public function AddEntreprises($entreprise)
    {
        $sql = $this->db->prepare('INSERT INTO `entreprises`(`owner`, `name`, `address`, `city`, `products`, `phone`) VALUES (?, ?, ?, ?, ?, ?)');
        $sql->execute(array($entreprise->getOwner(), $entreprise->getName(), $entreprise->getAddress(), $entreprise->getCity(), $entreprise->getProduct(), $entreprise->getPhone()));
        return true;
    }

    /*****************************************************************************************************************/

    public function GetAllEntreprises()
    {
        $entreprises = array();
        $sql = $this->db->prepare('SELECT * FROM `entreprises`');
        $sql->execute();
        while($row = $sql->fetch()) {
            $entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
            $entreprise->setId($row['id']);
            array_push($entreprises, $entreprise);
        }
        return $entreprises;
    }

    public function GetAllEntreprisesWithCity($city)
    {
        $entreprises = array();
        $sql = $this->db->prepare('SELECT * FROM `business` WHERE `city`=?');
        $sql->execute(array($city));
        while ($row = $sql->fetch()) {
            $entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['sell_type'], $row['payment_method']);
            array_push($entreprises, $entreprise);
        }
        return $entreprises;
    }

    public function GetAllEntreprisesWithProduct($product)
    {
        $entreprises = array();
        $sql = $this->db->prepare('SELECT * FROM `business` WHERE `sell_type`=?');
        $sql->execute(array($product));
        while ($row = $sql->fetch()) {
            $entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['sell_type'], $row['payment_method']);
            array_push($entreprises, $entreprise);
        }
        return $entreprises;
    }

    public function GetAllEntreprisesWithProductAndCity($product, $city)
    {
        $entreprises = array();
        $sql = $this->db->prepare('SELECT * FROM `business` WHERE `city`=? AND `sell_type`=?');
        $sql->execute(array($city, $product ));
        while ($row = $sql->fetch()) {
            $entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['sell_type'], $row['payment_method']);
            array_push($entreprises, $entreprise);
        }
        return $entreprises;
    }

}
?>