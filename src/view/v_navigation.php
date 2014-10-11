<?php
namespace view;

/**
 * Class containing static methods and functions for navigation.
 */
class NavigationView {
	public static $action = 'action';
	public static $id = 'id';
	
	public static $actionShowMember = 'show';
	public static $actionShowAll = 'showAll';
	public static $actionShowDetailedMemberlist = "showDetailedMemberlist";
	public static $actionAddMember = 'add';
	public static $actionAddBoat = 'addBoat';
	public static $portfolio = 'portfolio';
	public static $actionDeleteBoat = 'deleteBoat';  //TODO - change delete so it's not visible in the url
	public static $actionDeleteMember = 'deleteMember';
	public static $actionUpdateMember = 'updateMember'; 
	public static $actionUpdateBoat = 'updateBoat';
	
	/**
	 * Get the base menu with correct routed actions.;
	 * 
	 * @return String HTML
	 */
	public static function getMenu(){
		$html = "<div id='menu'>";
		$html .= "<a href='?".self::$action."=".self::$actionShowAll."'>Visa kompakt lista</a>&nbsp;";  //&nbsp = TAB TODO remove comment
		$html .= "<a href='?".self::$action."=".self::$actionShowDetailedMemberlist."'>Visa detaljerad lista</a>&nbsp;";  
		$html .= "<a href='?".self::$action."=".self::$actionAddMember."'>Lägg till medlem</a>&nbsp;";  // TODO - add list
		$html .= "</div>";
		return $html;
	}
	
	
	/**
	 * Return the current action asked for.
	 * 
	 * @todo Transform the action to a class of it's own?
	 * 
	 * @return String action
	 */
	public static function getAction() {
		if (isset($_GET[self::$action]))
			return $_GET[self::$action];
		
		return self::$actionShowAll;
	}
	
	/**
	 * Get a generic ID field.
	 * 
	 * @todo Create a "setId()" to connect it to the routing?
	 * 
	 * @return String
	 */
	public static function getId() {
		if (isset($_GET[self::$id])) {
			return $_GET[self::$id];
		}
		
		return NULL;
	}
	
	/**
	 * Redirect to home URL
	 */
	public static function RedirectHome() {
		header('Location: /' . \Settings::$ROOT_PATH. '/');
	}

	/**
	 * Redirect to home URL
	 */
	public static function RedirectToErrorPage() {
		header('Location: /' . \Settings::$ROOT_PATH. '/error.html');
	}
	
	/**
	 * Redirect to a member page.
	 * 
	 * @todo Move to member view?
	 * 
	 * @param String $uniqueString unique key for the member.
	 */
	public static function RedirectToMember($memberId) {
		header('Location: /' . \Settings::$ROOT_PATH. '/?'.self::$action.'='.self::$actionShowMember.'&portfolio='.$memberId);
	}
}
