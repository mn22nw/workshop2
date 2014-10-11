<?php

namespace controller;

//Dependencies
require_once("./src/view/v_portfolio.php");
require_once("./src/view/v_member.php");
require_once("./src/view/v_boat.php");
require_once("./src/model/m_memberList.php");
require_once('./src/model/m_memberRepository.php');
require_once('./src/model/m_boatRepository.php');
require_once('./src/model/m_validation.php');

/**
 * Controller for user related application flow.
 */
class MemberController {
	private $portfolioView;
	private $repository;
	private $memberView;
	private $boatRepository;
	private $validation; 
	private $boatView;

	/**
	 * Instantiate required views and required repositories.
	 */
	public function __construct() {
		$this->portfolioView = new \view\PortfolioView(); //Still required in class scope?
		$this->memberView = new \view\MemberView(); //Still required in class scope?
		$this->misc = new \helper\Misc(); 
		$this->memberRepository = new \model\MemberRepository();
		$this->boatRepository = new \model\BoatRepository();
		$this->validation = new \model\Validation();
		$this->boatView = new \view\BoatView();
	}

	/**
	* @return String HTML
	*/
	public function show() {
		if ($this->portfolioView->visitorHasChosenPortfolio() == false) {

			return $this->portfolioView->showAll($this->repository->toCompactList());//DRY? Use $this->showAll()?

		} else {
			$owner = $this->memberRepository->get($this->portfolioView->getOwner());  
	
			return $this->memberView->show($owner);    
		}
	}
	
	/**
	 * Get the HTML required to show all members in compact view.
	 * 
	 * @return String HTML
	 */
	public function showAllCompactview() {
		return $this->portfolioView->showCompactlist($this->memberRepository->toList());  
		// TODO write out all details!!
	}
	
	/**
	 * Get the HTML required to show all members in detailed view.
	 * 
	 * @return String HTML
	 */
	public function showAllDetailedView() {
		return $this->portfolioView->showDetailedlist($this->memberRepository->toList());  // TODO write out all details!!
		
	}
	
	
	/**
	 * Controller function to add a member.
	 * 
	 * Function will return HTML or Redirect.
	 * 
	 * @return Mixed
	 */
	public function addMember() {
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$newMember = $this->memberView->getFormData();    // gets the input from the form

			if($this->validation->validateMemberName($newMember[0],$newMember[1]) && $this->validation->validateMemberSecurityNumber($newMember[2])){
				$this->memberRepository->add(new \model\Member($newMember[0],$newMember[1], $newMember[2])); //adds member to database
			}else{
				return $this->memberView->getForm();
			}				
			
			\view\NavigationView::RedirectHome(); //TODO -Redirect to newly created member?
		} else {
			return $this->memberView->getForm();
		}
	}
	
	public function updateMember() {
			
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$updatedMember = $this->memberView->getFormData();    // gets the input from the updateform
			
			//VALIDATES IN MODEL BEFORE UPDATING //
			if ($this->validation->validateMemberName($updatedMember[0],$updatedMember[1]) && $this->validation->validateMemberSecurityNumber($updatedMember[2])){
				
				//updates member in database, first parameter = memberId //
				$this->memberRepository->update($updatedMember[3], new \model\Member($updatedMember[0],$updatedMember[1], $updatedMember[2])); 
			}
			
			else {
				$member = $this->memberRepository->get($updatedMember[3]); 
				return $this->memberView->getUpdateForm($member);  
			}				
			
			\view\NavigationView::RedirectToMember($updatedMember[3]); 
		} 
		
		else {
			$member = $this->memberRepository->get($this->memberView->getOwner()); 
			return $this->memberView->getUpdateForm($member);
		}
	}
	
	
	/**
	 * Controller function to add a boat.
	 * Function returns HTML or Redirect.
	 * 
	 * @TODO: Move to an own controller?
	 * 
	 * @return Mixed
	 */
	public function addBoat() {
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$boat = $this->boatView->getBoat();		 
			if($this->validation->validateBoatName($boat[0]) && $this->validation->validateBoatLength($boat[1])){

				$this->boatRepository->add(new \model\Boat("",$boat[0],$boat[1],$boat[2],$boat[3]));
			}else{
				return $this->boatView->getForm($this->memberRepository->get($boat[3]));
			}
			$member = $this->boatView->getOwnerUnique();  
			\view\NavigationView::RedirectToMember($member);
			//\view\NavigationView::RedirectHome();
			//\view\NavigationView::RedirectToMember($view->getOwnerUnique());
		} else {
			return $this->boatView->getForm($this->memberRepository->get(\view\NavigationView::getId()));
		}
	}
	
		/**
	 * Controller function to add a boat.
	 * Function returns HTML or Redirect.
	 * 
	 * @TODO: Move to an own controller?
	 * 
	 * @return Mixed
	 */
	public function updateBoat() {
		
		$boatId = $this->boatView->getBoatid();
		
		$boat = $this->boatRepository->get($boatId);  

		
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$updatedBoat = $this->boatView->getBoat();		
			
			if ($this->validation->validateBoatName($updatedBoat[0]) && $this->validation->validateBoatLength($updatedBoat[1])){

				$this->boatRepository->update($updatedBoat[4], new \model\Boat("",$updatedBoat[0],$updatedBoat[1],$updatedBoat[2],$updatedBoat[3]));
			}
			else{
					
				$member= $this->memberRepository->get($updatedBoat[3]);
				
				return $this->boatView->getUpdateForm($member, $boat );   
			}
			
			$memberId = $updatedBoat[3];	
			\view\NavigationView::RedirectToMember($memberId); 
		} 
		else {
			$member = $this->memberRepository->get($this->memberView->getOwner());
			
			return $this->boatView->getUpdateForm($member, $boat);
		}
	}
	
	
	public function deleteMember() {
				
			$member = $this->memberRepository->get($this->memberView->getOwner());  
			
			if (true){   // TODO - fixa confirm !

				//deletes member from database
				$this->memberRepository->delete($member); 
				
				\view\NavigationView::RedirectHome();
		  	 }
		   else{
		    // do nothing ?
		    // \view\NavigationView::RedirectHome(); //TODO -Redirect to member!?
		   }	
	}
	
	public function deleteBoat(){
		$member = $this->memberView->getOwner();  
		$boat = $this->boatRepository->get($this->memberView->getBoat());  
		
		$this->boatRepository->delete($boat); 
	
		\view\NavigationView::RedirectToMember($member);
		//\view\NavigationView::RedirectHome();
	}
}

