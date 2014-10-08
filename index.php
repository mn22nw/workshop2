<?php
require_once("src/view/HTMLView.php");
require_once("src/controller/c_navigation.php");

//maybe session start?
	
$view = new \view\HTMLView();

$navigation = new \controller\Navigation();

$htmlBody = $navigation->doControll();

$head = '<link rel="stylesheet" type="text/css" href="css/main.css">';

$view->echoHTML("Den glade piraten- Home", $head, $htmlBody);
