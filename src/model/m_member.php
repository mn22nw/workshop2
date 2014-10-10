<?php
namespace model;

require_once('./src/model/m_boatList.php');

class Member {
	private $memberId;
	private $name;
	private $surname;
	private $personalCn;
	private $boats;
	
	/**
	 * Constructor containing mocked overloading in PHP.
	 */
	public function __construct($name, $surname, $personalCn , BoatList $boats = NULL, $memberId = NULL) {
	
		if ($memberId == NULL) {
			$this->memberId = 0;
		}
		else {
			$this->memberId =$memberId;
		}
		//$this->$memberId = ($memberId == NULL) ? 0 : $memberId;
		$this->boats = ($boats == NULL) ? new BoatList(): $boats;
		$this->name = $name;
		$this->surname = $surname;
		$this->personalCn = $personalCn;

	}

	/**
	 * @return String
	 */
	public function getName() {
		return $this->name; //TODO - make this return member details ? Name, surname , personal code number, 	
	}

	public function getSurname() {
		return $this->surname; 
	}
	
	public function getPersonalCn() {
		return $this->personalCn; 
	}
	

	/**
	 * @return String
	 */
	public function getMemberId() {
		return $this->memberId;
	}
	
	/**
	 * Generate a new unique random string ID for a user. 
	 *
	 * @return Void
	 */
	public function setMemberId($memberId) {  // send this from memberrepository?
		$this->memberId;
	}
	
	
	/**
	 * Add a new boat to the user.
	 * Do not add empty boats!?
	 * 
	 * @param \model\Boat $boat Instance of the populated boat to add. 
	 * @return Void
	 */
	public function add(\model\Boat $boat) {
		$this->boats->add($boat);
	}
	
	/**
	 * @return \model\BoatList
	 */
	public function getBoats() {
		return $this->boats;
	}
	
}