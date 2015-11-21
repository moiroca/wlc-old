<?php

/**
 * Handles Logging Functionalities
 * 
 * @since November
 */
Class Log
{

	/**
	 * Save Login Logs
	 * 
	 * @param DB_Connection $db
	 * @param Int $user_id
	 */
	public static function saveLogin($db, $user_id)
	{
		$query = "INSERT INTO logs(user_id,date,time) VALUES ('".$user_id."', now(), now())";
		$db->query($query);
	}

	/**
	 * Update User Logs
	 *
	 * @param DB_Connection $db
	 * @param String $user_email
	 */
	public function updateUserLog($db, $user_email)
	{
		$query = "UPDATE user SET user_logs = now() WHERE user_email = $user_email";
		$db->query($query);
	}
}