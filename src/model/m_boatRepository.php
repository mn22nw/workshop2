<?php
namespace model;

require_once ('./src/model/base/Repository.php');
require_once ('./src/model/m_boatList.php');

class BoatRepository extends base\Repository {
	private $boats;
	
	private static $name = 'name';
	private static $length = 'length';
	private static $type = 'boatTypeFK';
	private static $key = 'uniqueKey';
	public static $owner = 'ownerMemberFK';
	
	public function __construct() {
		$this -> dbTable = 'boat';
		$this -> boats = new BoatList();
	}

	public function add(Boat $boat) {
		$db = $this -> connection();

		$sql = "INSERT INTO $this->dbTable (" . self::$key . ", " . self::$name . ", " . self::$length . ", ".self::$owner.", ".self::$type.") VALUES (?, ?, ?, ?, ?)";
		$params = array($boat -> getUnique(), $boat -> getName(), $boat->getLength() , $boat->getOwner()->getUnique(), $boat->getBoatType());

		$query = $db -> prepare($sql);
		$query -> execute($params);
	}

	public function get($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " = ?";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();

		if ($result) {
			return new \model\Member($result[self::$name], $result[self::$key]);  // TODO - add params here!
		}
	}

	public function find($unique) {
		
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " LIKE '%:unique%'";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute(array(':unique' => $unique));

		$memberList = new \model\MemberList();

		foreach ($query->fetchAll() as $result) {
			$memberList -> add(new \model\Boat($result[self::$name], $result[self::$key]));
		}

		return $memberList;
	}

	public function delete(Boat $boat) {
		$db = $this -> connection();

		$sql = "DELETE FROM $this->dbTable WHERE uniqueKey = ?";
		$params = array($boat -> getUnique());

		$query = $db -> prepare($sql);
		$query -> execute($params);

	}

	public function query($sql, $params = NULL) {
		$db = $this -> connection();

		$query = $db -> prepare($sql);
		$result;
		if ($params != NULL) {
			if (!is_array($params)) {
				$params = array($params);
			}

			$result = $query -> execute($params);
		} else {
			$result = $query -> execute();
		}

		if ($result) {
			return $result -> fetchAll();
		}

		return NULL;
		
	}

	public function toList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $boat) {
				$name = $boat['name'];
				$unique = $boat['uniqueKey'];

				$boat = new Boat($name, $unique);

				$this -> $boat -> add($boat);
			}

			return $this -> boats;
		} catch (\PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}

}
