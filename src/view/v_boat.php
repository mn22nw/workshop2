<?php
namespace view;

require_once('./src/model/m_boat.php');
require_once("./src/helper/Misc.php");

class BoatView {
	
	private static $name = 'name';
	private static $type = 'type';
	private static $length = 'length';
	private static $memberUnique = 'memberUnique';
	private $misc;
	
	public function __construct(){
		$this->misc = new \helper\Misc();
		
	}
	/**
	 * Populate a boat model with information from a view
	 * @todo create stupid boat that can be used to populate a smart project? SAY WHUUT?
	 * 
	 * @return \model\boat
	 */

	
	public function getBoat() {
		if (isset($_POST[self::$name])) {
			return array($_POST[self::$name], $_POST[self::$length], $_POST[self::$type], $_POST[self::$memberUnique]);
		}
		
		return NULL;
	}
	
	/**
	 * Generate HTML form to create a new boat bound to a member.
	 * 
	 * @param \model\Member $owner The member that should get the project registred to it.
	 * 
	 * @return String HTML
	 */
	public function getForm(\model\Member $owner) { // TODO - fixa boat med dropdown etc
		$message = $this->misc->getAlert();
		$name = $this->misc->getBoatName();
		
		$memberUnique = $owner->getMemberId();   
		$html = "<h1>Lägg till båt för ". $owner->getName(). " " .$owner->getSurname()."</h1>";
		$html .= "<a href='./'>Tillbaka</a>";
		$html .= "<form action='?action=".NavigationView::$actionAddBoat."' method='post'>";
		$html .= "<input type='hidden' name='".self::$memberUnique."' value='$memberUnique' />";
		$html .= "<label for='" . self::$name ." '>Båtnamn </label>";
		$html .= "<input type='text' name='".self::$name."' placeholder='Båtnamn' maxlength='60' value=$name >";
		$html .= "<label for='" . self::$length ."'>Längd i meter </label>";
		$html .= "<input type='text' name='" . self::$length . "'  maxlength='5' value=''><br /><br />";
		$html .= "<select name='" . self::$type . "'>
  				<option value='1'>Segelbåt</option>
  				<option value='2'>Motorseglare</option>
  				<option value='3'>Motorbåt</option>
  				<option value='4'>Kajak/Kanot</option>
  				<option value='5'>Övrig</option>
				</select>";
		$html .= "<input type='submit' value='Lägg till båt' />";
		$html .= "</form>";
		$html .= "<p>$message</p>";
		
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
