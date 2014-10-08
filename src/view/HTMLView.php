<?php
  namespace view;

  class HTMLView {

    /** 
      * Creates a HTML page. I blame the indentation
      * on webbrowser and PHP.
      *
      * @param string $title - The page title
      * @param string $body - The middle part of the page
      * @return string - The whole page
      */
		public function echoHTML($title, $head, $body) {
			if ($body === NULL) {
				throw new \Exception("HTMLView::echoHTML does not allow body to be null");
			}

			
			$html = "
				<!DOCTYPE html>
				<html>
				<head>
				<meta charset=\"utf-8\">
				<title>".$title."</title>
			    $head
				</head>
				<body>";
			$html .= "<div id='page'> ";
			$html .= \view\NavigationView::getMenu();
			$html .= "$body
				</div>
				</body>
				</html>";
				
			echo $html;
		}
}
