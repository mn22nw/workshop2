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
	
	/**
	 * Controller function to add a project.
	 * Function returns HTML or Redirect.
	 * 
	 * @TODO: Move to an own controller?
	 * 
	 * @return Mixed
	 */
	public function addBoat() {
		$view = new \view\BoatView();
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$boat = $view->getBoat();		
			if($this->validation->validateBoatName($boat[0]) && $this->validation->validateBoatLength($boat[1])){
				
				$this->boatRepository->add(new \model\Boat($boat[0],$boat[1],$boat[2],$boat[3]));
			}else{
				return $view->getForm($this->memberRepository->get($boat[3]));
			}
			
			\view\NavigationView::RedirectHome();
			//\view\NavigationView::RedirectToMember($view->getOwnerUnique());
		} else {
			return $view->getForm($this->memberRepository->get(\view\NavigationView::getId()));
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
}

