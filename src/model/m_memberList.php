<?php

namespace model;

require_once("m_member.php");

/**
 * Type secure collection of participants.
 */
class MemberList {
	private $portfolioOwners;
	
	public function __construct() {
		$this->portfolioOwners = array();
	}
	
	/**
	 * Returns an array of the participants.
	 *
	 * @return Array
	 */
	public function toArray() {
		
		return $this->portfolioOwners; 
	}
	
	/**
	 * Add a new member to the list.
	 * 
	 * @param \model\Member $member
	 * 
	 * @return Void
	 */
	public function add(Member $member) {
		if (!$this->contains($member))
			$this->portfolioOwners[] = $member;
	}
	
	/**
	 * Check if a member can be found within the list.
	 * 
	 * @param \model\MemberList $member The needle to look for.
	 * 
	 * @return Boolean
	 */
	public function contains(Member $member) {
		foreach($this->portfolioOwners as $key => $owner) {
			if ($owner->getMemberId() == $member->getMemberId() && $owner->getName() == $member->getName()) {
				return true;
			}
		}
		
		return false;
	}
}