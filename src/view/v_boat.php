<?php
namespace view;

require_once('./src/model/m_boat.php');

class BoatView {
	
	private static $name = 'name';
	private static $memberUnique = 'memberUnique';
	
	/**
	 * Populate a boat model with information from a view
	 * @todo create stupid boat that can be used to populate a smart project? SAY WHUUT?
	 * 
	 * @return \model\boat
	 */
	public function getboat() {
		if($this->getName() != NULL) {
			$boatName = $this->getName();
			return new \model\boat($boatName);
		}
	}
	
	/**
	 * Generate HTML form to create a new boat bound to a member.
	 * 
	 * @param \model\Member $owner The member that should get the project registred to it.
	 * 
	 * @return String HTML
	 */
	public function getForm(\model\Member $owner) { // TODO - fixa boat med dropdown etc
		$memberUnique = $owner->getMemberId();   
		
		$html = "<h1>Lägg till båt för ". $owner->getName(). " " .$owner->getSurname()."</h1>";
		$html .= "<form action='?action=".NavigationView::$actionAddBoat."' method='post'>";
		$html .= "<input type='hidden' name='".self::$memberUnique."' value='$memberUnique' />";
		$html .= "<input type='text' name='".self::$name."' />";
		$html .= "<input type='submit' value='Lägg till båt' />";
		$html .= "</form>";
		
		return $html;
	}
	
	/**
	 * Fetches boat name from a form.
	 * 
	 * @return String
	 */
	public function getName() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
		return null;
	}
	
	/**
	 * Fetches owner unique ID of a project owner.
	 * 
	 * @return String
	 */
	public function getOwnerUnique() {
		if (isset($_POST[self::$memberUnique])) {
			return $_POST[self::$memberUnique];
		}
		return NULL;
	}
}
