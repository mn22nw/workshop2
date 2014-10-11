<?php

namespace view;
/**
 * @todo Refactor together with BoatView and MemberView.
 * Some things might be better off in other views.
 */
class PortfolioView {    // TODO - rename portfolio!
	public static $getOwner = "portfolio"; //Made static
	
	public function getOwner() {
		if (isset($_GET[self::$getOwner])) {
			return $_GET[self::$getOwner];
		}
		
		return NULL;
	}

	public function visitorHasChosenPortfolio() {
		if (isset($_GET[self::$getOwner])) 
			return true;

		return false;
	}

	public function showCompactlist( \model\MemberList $members) {		
		$ret = "<h1> Kompakt lista över medlemmar</h1>";
		
		$ret .= "<ul id='memberlist'>";
		foreach ($members->toArray() as $member) {//Changed this to work with new navigation view.

			$ret .= "<li><a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getOwner."=" . 
					urlencode($member->getMemberId()) ."'>" .
					$member->getName(). " " .$member->getSurname() . "</a>";
			$ret .= "<p>Medlemsnr: " .$member->getMemberId(). " , Antal båtar: " . count($member->getBoats()->toArray())."</p>";
			$ret .= "<a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getOwner."=" . 
					urlencode($member->getMemberId()) ."' class ='showMemberbtn'> Visa medlem </a>";
			$ret .= "</li> ";
		};
		
		$ret .= "</ul>";
		
		return $ret;
	}
	
	public function showDetailedlist( \model\MemberList $members) {
		$i =0; 
				
		$ret = "<h1> Detaljerad lista över medlemmar</h1>";
		$ret .= "<ul id='memberlist'>";
		foreach ($members->toArray() as $member) {
			$ret .= "<li><a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getOwner."=" . 
					urlencode($member->getMemberId()) ."'>" .
					$member->getName(). " " .$member->getSurname() . "</a>";
			$ret .= "<p>Personnr: " .$member->getPersonalcn(). ", Medlemsnr: " .$member->getMemberId() . "</p>";
			$ret .= "<p><span>Båtinformation:</span> Antal båtar: " .count($member->getBoats()->toArray()). "</p>";
			
			foreach ($member->getBoats()->toArray()as $boat) {
				$i++;
				$ret .= "<p><span> ". $i. ") " .$boat->getName(). "</span></p><p> Längd: ".$boat->getLength() . "m,";
				$ret .= "<p>Båt-typ: ". $boat->getBoatType()."</p>";
			}
			$i = 0;
			$ret .= "<a href='?action=".NavigationView::$actionShowMember."&amp;".self::$getOwner."=" . 
					urlencode($member->getMemberId()) ."' class ='showMemberbtn'> Visa medlem</a>";
			$ret .= "</li> ";
		};
		
		$ret .= "</ul>";
		
		return $ret;
	}
}