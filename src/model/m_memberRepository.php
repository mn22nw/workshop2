<?php
namespace model;

require_once ('./src/model/m_member.php');
require_once ('./src/model/m_memberList.php');
require_once ('./src/model/base/Repository.php');

class MemberRepository extends base\Repository {
	private $members;

	private static $memberId = 'memberid';
	private static $name = 'name';
	private static $surname = 'surname';
	private static $personalCn ='personalcn';
	private static $boatTable = 'boat';

	public function __construct() {
		$this -> dbTable = 'member';
		$this -> members = new MemberList();
	}

	public function add(Member $member) {
		$db = $this -> connection();

		$sql = "INSERT INTO $this->dbTable (". self::$memberId . ", " . self::$name . " , " . self::$surname . ", " . self::$personalCn . ") VALUES ( ?, ?, ?, ?)";
		$params = array("",  $member -> getName(), $member -> getSurname(), $member -> getPersonalCn() );

		$query = $db -> prepare($sql);
		$query -> execute($params);
		
		//gets memberId from the newly created member
		$memberId = $this->getMemberId($member -> getName(), $member -> getPersonalCn());
		$member->setMemberId($memberId);
		urlencode($member->getMemberId());
		
		//har skapats ett nytt object i database med memberid
		//behöver hämta det och sen lägga in det i member jag skapat? 
		
		foreach($member->getBoats()->toArray() as $boat) {   // TODO - strängberoende memberUnique?
			$sql = "INSERT INTO ".self::$boatTable." (" . self::$memberId . ", " . self::$name . ", memberid) VALUES (?, ?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($boat->getUnique(), $boat->getName(), $member->getMemberId()));
		}
	}

	public function get($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$memberId . " = ?";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();

		if ($result) {
			$member = new \model\Member( $result[self::$name], $result[self::$surname],$result[self::$personalCn], NULL, $result[self::$memberId]);
			$sql = "SELECT * FROM ".self::$boatTable. " WHERE ".BoatRepository::$owner." = ?";  //TODO - check boatrepository!
			$query = $db->prepare($sql);
			$query->execute (array($result[self::$memberId]));
			$boats = $query->fetchAll();
			foreach($boats as $boat) {
				$newBoat = new Boat($boat['name'], $boat['$memberId']);  //TODO add parameters here!
				$member->add($newBoat);
			}
			return $member;
		}

		return NULL;
	}

	public function getMemberId($name, $personalCn) {
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$name . " = ? AND " . self::$personalCn . "= ?";
		$params = array($name, $personalCn);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();	
		
		return $result->name;	
			
    }
	

	public function find($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$memberId . " LIKE '%:memberid%'";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute(array(':unique' => $unique));

		$memberList = new \model\MemberList();

		foreach ($query->fetchAll() as $result) {
			$memberList -> add(new \model\Member($result[self::$name], $result[self::$memberId])); 
		}
	
		return $memberList;

	}

	public function delete(\model\Member $member) {
		$db = $this -> connection();

		$sql = "DELETE FROM $this->dbTable WHERE " . self::$memberId . "= ?";
		$params = array($member -> getMemberId());

		$query = $db -> prepare($sql);
		$query -> execute($params);
	}

	public function toCompactList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $owner) {
				$name = $owner[self::$name];
				$memberId = $owner[self::$memberId];  
				$surname = $owner[self::$surname];
				$personalcn = $owner[self::$personalCn];   

				$member = new Member($name, $surname, $personalcn, NULL, $memberId);   

				$this -> members -> add($member);   
			}

			return $this -> members;
			
		} catch (\PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}
	
	public function toDetailedList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $owner) {
				$name = $owner[self::$name];
				$memberId = $owner[self::$memberId]; 
				$surname = $owner[self::$surname];
				$personalcn = $owner[self::$personalCn]; 

				$member = new Member($name, $surname, $personalcn, NULL, $memberId); // TODO get number of boats!

				$this -> members -> add($member);   // TODO - write out surname etc
			}

			return $this -> members;
		} catch (\PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}

}
