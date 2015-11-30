<?php

/**
 * Page Utility
 *
 * @since November
 */
class PageUtility
{
	/**
	 * Show Page For Specific User
	 *
	 * @param Array $userTypes
	 *
	 * @return Mixed
	 */
	public static function showPageFor($userTypes)
	{
		if (in_array($_SESSION['type'], $userTypes)) {
			return true;
		} else {
			throw new Exception('404: Page Not Found');
		}
	}
}