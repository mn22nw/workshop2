<?php
namespace controller;
require_once('./src/view/v_navigation.php');
require_once('./src/controller/c_member.php');
require_once('Settings.php');

/**
 * Navigation view for a simple routing solution.
 */
class Navigation {
	
	/**
	 * Checks what controller to instansiate and return value of to HTMLView.
	 */
	public function doControll() {
		$controller;

		try {
			switch (\view\NavigationView::getAction()) {
				case \view\NavigationView::$actionAddMember:
					$controller = new MemberController();
					return $controller->addMember();
					break;
					
				case \view\NavigationView::$actionShowMember:
					$controller = new MemberController();
					return $controller->show();
					break;
				
				case \view\NavigationView::$actionUpdateMember:
					$controller = new MemberController();
					return $controller->updateMember();
					break;	
					
				case \view\NavigationView::$actionAddBoat:
					$controller = new MemberController();
					return $controller->addBoat(); 
				
				case \view\NavigationView::$actionUpdateBoat:
					$controller = new MemberController();
					return $controller->updateBoat(); 
					
				case \view\NavigationView::$actionDeleteBoat:
					$controller = new MemberController();
					return $controller->deleteBoat();
					
				case \view\NavigationView::$actionDeleteMember:
					$controller = new MemberController();
					return $controller->deleteMember();   
					
				case \view\NavigationView::$actionShowDetailedMemberlist:
					$controller = new MemberController();
					return $controller->showAllDetailedView();
					
				default:
					$controller = new MemberController();
					return $controller->showAllCompactView();
					break;
			}
		} catch (\Exception $e) {

			error_log($e->getMessage() . "\n", 3, \Settings::$ERROR_LOG);
			if (\Settings::$DO_DEBUG) {
				throw $e;
			} else {
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}
}
