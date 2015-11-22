<?php

/**
 * @since November 2015
 */
Class Login {

	/**
	 * Start Session
	 */
	public static function sessionStart()
	{
		session_start();
	}

	/**
	 * Check if Username and Password Set
	 *
	 * @return Boolean
	 */
	public static function checkIfUsernamePasswordSet()
	{
		return (isset($_POST['username']) && isset($_POST['password']));
	}

	/**
	 * Redirect To Login
	 *
	 * @param Boolean $isLoginError
	 */
	public static function redirectToLogin()
	{
		header('location: http://'.$_SERVER['HTTP_HOST'].'/index.php');
	}

	/**
	 * Redirect To HomePage
	 */
	public static function redirectToHome()
	{
		header('location: http://'.$_SERVER['HTTP_HOST'].'/Pages/home.php');
	}

	/**
	 * Set Login Error to True;
	 */
	public static function setIsLoginError() 
	{
		$_SESSION['isLoginError'] = true;
	}

	/**
	 * Set Login Error to True;
	 */
	public static function resetIsLoginError() 
	{
		$_SESSION['isLoginError'] = false;
	}

	/**
	 * Check if Login Has Error
	 *
	 * @return Boolean
	 */
	public static function checkIfLoginHasError()
	{
		if (isset($_SESSION['isLoginError']) && $_SESSION['isLoginError']) {
			
			self::resetIsLoginError();
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Destroy Session
	 */
	public static function destroySession()
	{
		session_destroy();
	}

	/**
	 * Check if Logged In
	 */
	public static function isLoggedIn()
	{
		return isset($_SESSION['type']);
	}
}