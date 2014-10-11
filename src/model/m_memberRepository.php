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
	private static $memberFK = 'OwnerMemberFK';

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
			
	}
	
	
	public function update($memberId, Member $member) {
		$db = $this -> connection();
		
		// query
		$sql = "UPDATE $this->dbTable 
		        SET name=?, surname=? , personalcn=? 
				WHERE memberid=?";
				
		$params = array($member -> getName(), $member -> getSurname(), $member -> getPersonalCn(), $memberId);		
		$query = $db -> prepare($sql);
		$query -> execute($params);
		
	/*	
		$sql ="UPDATE  $this->dbTable   
			   SET `" . self::$name . "` = ". $member -> getName() . ",
			       `" . self::$surname . "` = ". $member -> getSurname() . ",
			       `" . self::$personalCn . "` = ". $member -> getPersonalCn() . "
				 WHERE ". self::$memberId . " = ".  $memberId;		*/
	
	}

/*foreach($member->getBoats()->toArray() as $boat) {   // TODO - strängberoende memberid?
			$sql = "INSERT INTO ".self::$boatTable." (" . self::$memberId . ", " . self::$name . ", " . self::$memberId . ") VALUES (?, ?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($boat->getUnique(), $boat->getName(), $member->getMemberId()));
		}*/



	public function get($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$memberId . " = ?";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();

		if ($result) {
			$member = new \model\Member( $result[self::$name], $result[self::$surname],$result[self::$personalCn], NULL, $result[self::$memberId]);
			$sql = "SELECT * FROM ".self::$boatTable. " WHERE ".BoatRepository::$owner." = ?";  
			$query = $db->prepare($sql);
			$query->execute (array($result[self::$memberId]));
			$boats = $query->fetchAll();
			foreach($boats as $boat) {
				
				$newBoat = new Boat($boat['boatid'],$boat['name'], $boat['length'], $boat['boatTypeFK'], $boat['ownerMemberFK']);  
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
		
		$sql = "DELETE FROM ".self::$boatTable."  WHERE " . self::$memberFK . "= ?";
		$params = array($member -> getMemberId());
		
		$query = $db -> prepare($sql);
		$query -> execute($params);
		

		$sql = "DELETE FROM $this->dbTable WHERE " . self::$memberId . "= ?";
		$params = array($member -> getMemberId());

		$query = $db -> prepare($sql);
		$query -> execute($params);
	
		
	}

	public function toList() {  // TODO need to add boats here to member!
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $member) {
				$name = $member[self::$name];
				$surname = $member[self::$surname];
				$personalcn = $member[self::$personalCn];  
				$memberId = $member[self::$memberId];   

				$member = new Member($name, $surname, $personalcn, NULL, $memberId); 
				
				//Select boats from member
				$sql = "SELECT * FROM ".self::$boatTable. " WHERE ".BoatRepository::$owner." = ?";  
				$query = $db->prepare($sql);
				$query->execute (array($memberId));
				$boats = $query->fetchAll();
				
				// Add boats to member
				foreach($boats as $boat) {  // TODO - ta bort strängberoenden!!
					$newBoat = new Boat($boat['boatid'], $boat['name'], $boat['length'], $boat['boatTypeFK'], $boat['ownerMemberFK']);  
					$member->add($newBoat);
				}	

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
}
