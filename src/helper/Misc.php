<?php
  namespace helper;

  class Misc {
    private static $sessionAlert = "sessionAlert";
	private static $sessionName = "name";
	private static $sessionLastName = "lastname";
	private static $sessionBoatName = "boatname";
    /**
      * Get an alert from the session alert system
      * if there are any messages and the deletes it
      * from the session.
      *
      * @return string - The message
      */
    public function getAlert() {
      if (isset($_SESSION[self::$sessionAlert])) {
        $ret = $_SESSION[self::$sessionAlert];
        unset($_SESSION[self::$sessionAlert]);
      } else {
        $ret = "";
      }
      return $ret;
    }

    /**
      * Set an alert to the session alert system
      *
      * @param string $string - The message to save
      * @return boolval
      */
    public function setAlert($string) {
      $_SESSION[self::$sessionAlert] = $string;
    }
	
	public function setName($name) {
      $_SESSION[self::$sessionName] = $name;
    }
	   
	public function getName() {
      if (isset($_SESSION[self::$sessionName])) {
        $ret = $_SESSION[self::$sessionName];
        unset($_SESSION[self::$sessionName]);
      } else {
        $ret = "";
      }
      return $ret;
    }
		
	public function setLastName($lastname) {
      $_SESSION[self::$sessionLastName] = $lastname;
    }
	
	public function getLastName() {
      if (isset($_SESSION[self::$sessionLastName])) {
        $ret = $_SESSION[self::$sessionLastName];
        unset($_SESSION[self::$sessionLastName]);
      } else {
        $ret = "";
      }
      return $ret;
    }
		
   public function setBoatName($name) {
      $_SESSION[self::$sessionBoatName] = $name;
    }

	public function getBoatName() {
      if (isset($_SESSION[self::$sessionBoatName])) {
        $ret = $_SESSION[self::$sessionBoatName];
        unset($_SESSION[self::$sessionBoatName]);
      } else {
        $ret = "";
      }
      return $ret;
    }
    /**
      * Makes the param safe from html and stuff...
      *
      * @param string $var - The dirty string
      * @return string - The cleaned up string
      */
    public function makeSafe($var) {
      $var = trim($var);
      $var = stripslashes($var);
      $var = htmlentities($var);
      $var = strip_tags($var);

      return $var;
    }


  }
