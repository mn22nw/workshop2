<?php
namespace model;

class Boat {
	private $unique;
	private $name;
	private $type;
	private $length;
	private $owner;
	
	public function __construct($name, $type, $length, $unique = NULL, $owner = NULL) {
		if (empty($name)) {
			throw new Exception('Name of boat cannot be empty.');
		}
		$this->owner = $owner;
		$this->name = $name;
		$this->type = $type;
		$this->length = $length;
		$this->unique = ($unique == null) ? \uniqid() : $unique;
	}
	
	public function equals(Boat $other) {
		return (
			$this->getName() == $other->getName() &&
			$this->getUnique() == $this->getUnique()
			);
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getLength() {
		return $this->length;
	}
	
	public function getBoatType() {
		return $this->type;
	}
	
	
	public function getUnique() {
		return $this->unique;
	}
	
	public function setOwner(Member $owner) {
		$this->owner = $owner;
	}
	
	public function getOwner() {
		return $this->owner;
	}
}
