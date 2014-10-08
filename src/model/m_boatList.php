<?php
namespace model;

class BoatList {
	private $boats;
	
	public function __construct() {
		$this->boats = array();
	}
	
	public function toArray() {
		return $this->boats; 
	}
	
	public function add(Boat $boat) {
		if (!$this->contains($boat))
			$this->boats[] = $boat;
	}
	
	public function contains(Boat $boat) {
		foreach($this->boats as $key => $value) {
			if ($boat->equals($value)) {
				return true;
			}
		}
		
		return false;
	}
}