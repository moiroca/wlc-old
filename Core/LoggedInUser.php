<?php

/**
 * LoggedInUser Class
 *
 * @since November 2015
 */
Class LoggedInUser
{
	public function __construct() { }

	/**
	 * Get Login User Type
	 */
	public static function type()
	{
		return isset($_SESSION['login']) ? $_SESSION['login'] : null;
	}
}