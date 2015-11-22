<?php

/**
 * Class Template
 *
 * @since November 2015
 */
Class Template
{
	/**
	 * Header
	 */
	public static function header()
	{
		include $_SERVER['DOCUMENT_ROOT'].'/Pages/Includes/header.php';
	}

	/**
	 * Footer
	 */
	public static function footer()
	{
		include $_SERVER['DOCUMENT_ROOT'].'/Pages/Includes/footer.php';
	}
}