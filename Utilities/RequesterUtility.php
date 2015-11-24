<?php

Class RequesterUtility
{
	/**
	 * Get Requester Full Name
	 */
	public static function getFullName($data)
	{
		return ucwords($data['user_lastname']).', '.ucwords($data['user_firstname']).' ';
	}
}