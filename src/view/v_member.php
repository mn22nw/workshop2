<?php
namespace view;
require_once("./src/helper/Misc.php");
class MemberView {
	private static $getLocation = "member"; 
	
	private static $name = 'name';
	private static $surname = 'surname';
	private static $personalcn = 'personalcn';
	
	private $misc;
	
	public function __construct(){
		$this->misc = new \helper\Misc();
		
	}
	public function getOwner() {
		if (isset($_GET[self::$getLocation])) {
			return $_GET[self::$getLocation];
		}
		
		return NULL;
	}
	
	
	/**
	 * Populate a new member model from form data.
	 * @todo Maybe put this in a controller? Create new member model that is dumber?
	 * 
	 * @return \model\Member
	 */
	public function getFormData() {
		if (isset($_POST[self::$name])) {
			return array($_POST[self::$name], $_POST[self::$surname], $_POST[self::$personalcn]);
		}
		
		return NULL;
	}
	
	/**
	 * Retrieves the form to be used to when adding a new member.
	 * 
	 * @return String HTML
	 */
	public function getForm() {
	
		$message = $this->misc->getAlert();
		$firstname = $this->misc->getName();
		$lastname = $this->misc->getLastName();
		
		$html = "<div id='addMember'>";
		$html .= "<h1>Lägg till medlem</h1>";
		$html .= "<a href='./'>Tillbaka</a>";
		$html .= "<form method='post' action='?action=".NavigationView::$actionAddMember."'>";
		$html .= "<label for='" . self::$name . "'>Förnamn: </label>";
		$html .= "<input type='text' name='" . self::$name . "' placeholder='Förnamn' maxlength='30' value=$firstname><br />";
		$html .= "<label for='" . self::$surname . "'>Efternamn: </label>";
		$html .= "<input type='text' name='" . self::$surname . "' placeholder='Efternamn' maxlength='60' value=$lastname><br />";		
		$html .= "<label for='" . self::$personalcn . "'>Personnummer : </label>";
		$html .= "<input type='text' name='" . self::$personalcn . "' placeholder='xxxxxxxxxx' maxlength='10' value=''><br /><br />";
		$html .= "<input type='submit' value='Lägg till Medlem' />";
		$html .= "</form>";
		$html .= "<p>$message</p>";
		$html .= "</div>";
		
		return $html;
	}
	
	/**
	 * Creates the HTML needed to display a user with a list of projects.
	 * 
	 * @return String HTML
	 */
	public function show(\model\Member $member) {  
		$boatArray = $member->getBoats()->toArray();
		$ret = '<h1>' . $member->getName() . " " . $member->getSurname() . '</h1>';
		$ret .= "<p><span>Personnr: </span>" .$member->getPersonalcn(). " <span> Medlemsnr: </span>" .$member->getMemberId() . "</p>";
		$ret .= "<a href='?action=".NavigationView::$actionDeleteMember."&amp;".self::$getLocation."=" . 
					urlencode($member->getMemberId()) ."' class = 'deleteBtn'> Ta bort medlem </a>";
		$ret .= "<h2>Båtar</h2>";
		$ret .= "<ul id='boats'>";
		foreach($boatArray as $boat) {
			$ret .= "<li><span> ".$boat->getName()." </span><p> Längd: ".$boat->getLength() . "m,";
			$ret .= " Båt-typ: ". $boat->getBoatType()."</p></li>";
		}
		$ret .= "</ul>";
		
		if (empty($boatArray)) 
		$ret .= "<p>Har ej en båt registrerad.</p> <br />";
		
		// add-button //
		$ret .= "<a href='?".NavigationView::$action."=".NavigationView::$actionAddBoat."&".NavigationView::$id."=".$member->getMemberId()."'";
		$ret .= "class = 'addBtn'>Lägg till båt</a>&nbsp;";
	
		return $ret;
	}
}
