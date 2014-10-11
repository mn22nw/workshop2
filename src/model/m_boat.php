<?php
namespace model;

class Boat {
	
	public $boatid;
	public $name;
	public $type;
	public $length;
	public $owner;

	
	public function __construct($boatid, $name, $length, $type, $owner) {
		
		$this->boatid = $boatid;
		$this->owner = $owner;
		$this->name = $name;
		$this->type = $type;
		$this->length = $length;
		

	}
	
	public function equals(Boat $other) {
		return (
			$this->getName() == $other->getName() &&
			$this->getUnique() == $this->getUnique()
			);
	}
	
	public function getBoatId() {
		return $this->boatid;
	}
	
	
	public function getName() {
		return $this->name;
	}
	
	public function getLength() {
		return $this->length;
	}
	
	public function getBoatTypeNr(){
		return $this->type;
	}
	
	public function getBoatType() {  // TODO  ta bort strängberoende om de finns
	
		switch ($this->type) {
			case '1':
				return "Segelbåt";
				break;
			case '2':
				return "Motorseglare";
				break;	
			case '3':
				return "Motorbåt";
				break;
			case '4':
				return "Kajak/Kanot";
				break;
			case '5':
				return "Övrigt";
				break;
		} 
	}
	
	
	
	public function setOwner(Member $owner) {
		$this->owner = $owner;
	}
	
	public function getOwner() {
		return $this->owner;
	}
}
