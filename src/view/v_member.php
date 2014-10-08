<?php
namespace view;

class MemberView {
	private static $getLocation = "member"; 
	
	private static $name = 'name';
	private static $surname = 'surname';
	private static $personalcn = 'personalcn';
	
	
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
			return new \model\Member($_POST[self::$name], $_POST[self::$surname], $_POST[self::$personalcn]);
		}
		
		return NULL;
	}
	
	/**
	 * Retrieves the form to be used to when adding a new member.
	 * 
	 * @return String HTML
	 */
	public function getForm() {
		
		$html = "<div id='addMember'>";
		$html .= "<h1>Lägg till medlem</h1>";
		$html .= "<form method='post' action='?action=".NavigationView::$actionAddMember."'>";
		$html .= "<label for='" . self::$name . "'>Förnamn: </label>";
		$html .= "<input type='text' name='" . self::$name . "' placeholder='Förnamn' value='' maxlength='30'><br />";
		$html .= "<label for='" . self::$surname . "'>Efternamn: </label>";
		$html .= "<input type='text' name='" . self::$surname . "' placeholder='Efternamn' value='' maxlength='60'><br />";		
		$html .= "<label for='" . self::$personalcn . "'>Personnummer : </label>";
		$html .= "<input type='text' name='" . self::$personalcn . "' placeholder='xxxxxx-xxxx' value='' maxlength='11'><br /><br />";
		$html .= "<input type='submit' value='Lägg till Medlem' />";
		$html .= "</form>";
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
		$ret .= "<ul>";
		foreach($boatArray as $boat) {
			$ret .= "<li>".$boat->getName()."</li>";
		}
		$ret .= "</ul>";
		
		if (empty($boatArray)) 
		$ret .= "<p>Har ej en båt registrerad.</p> <br />";
		
		$ret .= NavigationView::getMemberMenu($member->getMemberId());  //<--- TODO - rename? cos it's the add boat button...
		
		return $ret;
	}
}
