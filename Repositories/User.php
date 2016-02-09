<?php

/**
 * Users Class
 */
Class User extends Base
{
	public $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Data
	 *
	 * @param Int $userId
	 * @param String $email
	 */
	public function findNotUser($userId, $email)
	{
		$sql = "
			SELECT 
				email 
			FROM 
				users 
			WHERE 
				`users`.`id` != $userId
			AND
				`users`.`email`= '".$email."'
			";

		return $this->raw($sql);
	}
}