<?php

include './Utilities/Constant.php';
include './Database/Db.php';

/**
 * @since November 2015 
 */
Class DbConnection{

	private static $_instance; //The single instance

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function connect() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// Constructor
	private function __construct() {
		$this->_connection = new mysqli(Constant::DB_HOST, Constant::DB_USER, 
			Constant::DB_PASS, Constant::DB_NAME);
	
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}