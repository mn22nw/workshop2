<?php

namespace model;

require_once("m_member.php");

class MemberBook {

	public function getMembers() {
		$portfolioOwners = array(new \model\Member("Something","Maria"),   //TODO - change something!
								 new \model\Member("Something","Annie"));  //TODO rename portfolio to boat??

		return $portfolioOwners; 
	}
}