<?php

namespace view;
/**
 * @todo Refactor together with BoatView and MemberView.
 * Some things might be better off in other views.
 */
class PortfolioView {    // TODO - rename portfolio!
	private static $getLocation = "portfolio"; //Made static
	
	public function getOwner() {
		if (isset($_GET[self::$getLocation])) {
			return $_GET[self::$getLocation];
		}
		
		return NULL;
	}

	public function visitorHasChosenPortfolio() {
		if (isset($_GET[self::$getLocation])) 
			return true;

		return false;
	}

	public function showCompactlist( \model\MemberList $portfolioOwners) {		
		$ret = "<h1> Kompakt lista över medlemmar</h1>";
		
		$ret .= "<ul id='memberlist'>";
		foreach ($portfolioOwners->toArray() as $member) {//Changed this to work with new navigation view.

			$ret .= "<li><a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getLocation."=" . 
					urlencode($member->getMemberId()) ."'>" .
					$member->getName(). " " .$member->getSurname() . "</a>";
			$ret .= "<p>Medlemsnr: " .$member->getMemberId(). " , Antal båtar: " . count($member->getBoats()->toArray())."</p>";
			$ret .= "<a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getLocation."=" . 
					urlencode($member->getMemberId()) ."' class ='showMemberbtn'> Visa </a>";
			$ret .= "</li> ";
		};
		
		$ret .= "</ul>";
		
		return $ret;
	}
	
	public function showDetailedlist( \model\MemberList $portfolioOwners) {		
		$ret = "<h1> Detaljerad lista över medlemmar</h1>";
		$ret .= "<ul id='memberlist'>";
		foreach ($portfolioOwners->toArray() as $member) {//Changed this to work with new navigation view.
			$ret .= "<li><a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getLocation."=" . 
					urlencode($member->getMemberId()) ."'>" .
					$member->getName(). " " .$member->getSurname() . "</a>";
			$ret .= "<p>Personnr: " .$member->getPersonalcn(). ", Medlemsnr: " .$member->getMemberId();
			$ret .= ", Antal båtar: " .count($member->getBoats()->toArray()). "</p>";
			$ret .= "<a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getLocation."=" . 
					urlencode($member->getMemberId()) ."' class ='showMemberbtn'> Visa </a>";
			$ret .= "</li> ";
		};
		
		$ret .= "</ul>";
		
		return $ret;
	}
}