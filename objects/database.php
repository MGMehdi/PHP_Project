<?php
require_once 'user.php';
require_once 'entreprise.php';
require_once 'city.php';

class Database
{
	private static $dsn = 'mysql:dbname=php;host=127.0.0.1';
	private static $dbUser = 'root';
	private static $dbPassword = '';
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
			$sql->execute(array(htmlspecialchars_decode($user->getName()), htmlspecialchars_decode($user->getSurname()), htmlspecialchars_decode($user->getMail()), $user->getPassword()));
			$user->setPassword('');
			return $user;
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function GetUser($id)
	{
		$sql = $this->db->prepare('SELECT * FROM `users` WHERE `id`=?');
		$sql->execute(array($id));

		while ($row = $sql->fetch()) {
			return $user = new User($row['id'], $row['name'], $row['surname'], $row['mail'], $row['password'], $row['isadmin'], $row['isseller']);
		}
	}

	public function GetAllNewSeller()
	{
		$newSeller = array();
		$sql = $this->db->prepare('SELECT `id`, `name`, `surname`, `mail`, `isseller` FROM `users` WHERE `isseller`=2');

		$sql->execute();
		while ($row = $sql->fetch()) {
			$seller = new User($row['id'], $row['name'], $row['surname'], $row['mail'], '', '', $row['isseller']);
			array_push($newSeller, $seller);
		}
		return $newSeller;
	}

	public function DeleteUser($id)
	{
		$sql = $this->db->prepare('DELETE FROM `users` WHERE `id`=?');
		$sql->execute(array($id));
		return true;
	}

	public function updatePassword($user)
	{
		print_r($user);

		$sql = $this->db->prepare('UPDATE `users` SET `password`=? WHERE id=?');
		$sql->execute(array($user->getPassword(), $user->getId()));
		return true;
	}

	public function updateUser($user)
	{
		$sql = $this->db->prepare('UPDATE `users` SET `name`=?, surname=?, mail=? WHERE id=?');
		$sql->execute(array(htmlspecialchars_decode($user->getName()), htmlspecialchars_decode($user->getSurname()), htmlspecialchars_decode($user->getMail()), $user->getId()));
		return true;
	}

	public function beASeller($user)
	{
		$sql = $this->db->prepare('UPDATE `users` SET `isseller`=' . $user->getSeller() . ' WHERE id=?');
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
			$city = new City($row['id'],$row['city'], $row['province']);
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
			$city = new City($id, $row['city'], $row['province']);
			$city->setId($id);
		}
		return $city;
	}

	public function UpdateCity($city)
	{
		$sql = $this->db->prepare('UPDATE `location` SET `city`=?, province=? WHERE id=?');
		$sql->execute(array(htmlspecialchars_decode($city->getCity()), htmlspecialchars_decode($city->getProvince()), $city->getId()));
		return true;
	}

	public function AddCity($city)
	{
		try {
			$sql = $this->db->prepare('INSERT INTO `location` (`city`, `province`) VALUES ( ?, ?)');
			$sql->execute(array(htmlspecialchars_decode($city->getCity()), htmlspecialchars_decode($city->getProvince())));
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	public function DeleteCity($id)
	{
		$sql = $this->db->prepare('DELETE FROM `location` WHERE `id`=?');
		$sql->execute(array($id));
		return true;
	}

	/*****************************************************************************************************************/

	public function GetMyEntreprises($id)
	{
		$entreprises = array();
		$sql = $this->db->prepare('SELECT * FROM `entreprises` WHERE `owner`=?');
		$sql->execute(array($id));


		while ($row = $sql->fetch()) {
			$entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
			$entreprise->setId($row['id']);
			array_push($entreprises, $entreprise);
		}
		return $entreprises;
	}

	public function GetMyEntreprise($id)
	{
		$sql = $this->db->prepare('SELECT * FROM `entreprises` WHERE `id`=?');
		$sql->execute(array($id));
		while ($row = $sql->fetch()) {
			$entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
		}
		$entreprise->setId($id);
		return $entreprise;
	}


	public function AddEntreprises($entreprise)
	{
		$sql = $this->db->prepare('INSERT INTO `entreprises`(`owner`, `name`, `address`, `city`, `products`, `phone`) VALUES (?, ?, ?, ?, ?, ?)');
		$sql->execute(array($entreprise->getOwner(), htmlspecialchars_decode($entreprise->getName()), htmlspecialchars_decode($entreprise->getAddress()), $entreprise->getCity(), htmlspecialchars_decode($entreprise->getProduct()), htmlspecialchars_decode($entreprise->getPhone())));
		return true;
	}

	public function UpdateEntreprises($entreprise)
	{
		error_log(print($entreprise->getId()));
		$sql = $this->db->prepare('UPDATE `entreprises` SET `owner`=?, `name`=?, `address`=?, `city`=?, `products`=?, `phone`=? WHERE `id`=?');
		$sql->execute(array($entreprise->getOwner(), htmlspecialchars_decode($entreprise->getName()), htmlspecialchars_decode($entreprise->getAddress()), $entreprise->getCity(), htmlspecialchars_decode($entreprise->getProduct()), htmlspecialchars_decode($entreprise->getPhone()), $entreprise->getId()));
		return true;
	}

	public function DeleteAllEntrepris($id)
	{
		$sql = $this->db->prepare('DELETE FROM `entreprises` WHERE `id`=?');
		$sql->execute(array($id));
		return true;
	}

	public function DeleteEntreprise($id)
	{
		$sql = $this->db->prepare('DELETE FROM `entreprises` WHERE `id`=?');
		$sql->execute(array($id));
		return true;
	}

	/*****************************************************************************************************************/

	public function GetAllEntreprises()
	{
		$entreprises = array();
		$sql = $this->db->prepare('SELECT * FROM `entreprises`');
		$sql->execute();
		while ($row = $sql->fetch()) {
			$entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
			$entreprise->setId($row['id']);
			array_push($entreprises, $entreprise);
		}
		return $entreprises;
	}

	public function GetAllEntreprisesWithCity($city)
	{
		$entreprises = array();
		$sql = $this->db->prepare('SELECT * FROM `entreprises` WHERE `city`=?');
		$sql->execute(array($city));
		while ($row = $sql->fetch()) {
			$entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
			array_push($entreprises, $entreprise);
		}
		return $entreprises;
	}

	public function GetAllEntreprisesWithProduct($product)
	{
		$entreprises = array();
		$sql = $this->db->prepare('SELECT * FROM `entreprises` WHERE `products`=?');
		$sql->execute(array($product));
		while ($row = $sql->fetch()) {
			$entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
			array_push($entreprises, $entreprise);
		}
		return $entreprises;
	}

	public function GetAllEntreprisesWithProductAndCity($product, $city)
	{
		$entreprises = array();
		$sql = $this->db->prepare('SELECT * FROM `entreprises` WHERE `city`=? AND `products`=?');
		$sql->execute(array($city, $product));
		while ($row = $sql->fetch()) {
			$entreprise = new Entreprise($row['owner'], $row['name'], $row['address'], $row['city'], $row['products'], $row['phone']);
			array_push($entreprises, $entreprise);
		}
		return $entreprises;
	}
}
