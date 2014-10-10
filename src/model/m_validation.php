<?php
namespace model;
require_once("./src/helper/Misc.php");

class Validation{
	
	private $misc;
	
	public function __construct(){
		$this->misc = new \helper\Misc();
	}
	
	public function validateMemberName($firstname, $lastname){
		if($firstname != "" && $lastname != ""){
		
			$this->misc->setName($firstname);
			$this->misc->setLastName($lastname);
			return true; 
		}else{
			$this->misc->setAlert("Förnamn och Efternamn måste vara ifyllda!");
			return false;
		}	
	}
	
	public function validateMemberSecurityNumber($securityNumber){
		
		if (is_numeric($securityNumber) === true && strlen(trim($securityNumber)) == 10){
			
			return true;
		}else{
			$this->misc->setAlert("Personnummret måste vara i formen: 8904201010");
			return false;
		}
	}
	
	public function validateBoatName($boatName){
		if(strlen($boatName) >= 1){
			$this->misc->setBoatName($boatName);
			return true; 
		}else{
			$this->misc->setAlert("Båten måste ha ett namn!");
			return false;
			
		}
		
	}	
	public function validateBoatLength($boatLength){
		if(is_numeric($boatLength) === true){
			return true; 
		}else{
			$this->misc->setAlert("Båtens längd ska anges i meter, tex: 6.8");
			return false;
			
		}
	}
}
