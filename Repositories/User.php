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
	 * Get All User
	 *
	 * @return Mysqli Connection
	 */
	public function getAllUser() 
	{ 
		$sql = "
			SELECT 
				*
			FROM
				`users`
		";

		return $this->connection->query($sql);
	}

	/**
	 * Get User By Username
	 *
	 * @param String $username
	 *
	 * @return Mysqli
	 */
	public function getUserByUsername($username) { 

		$sql = "
			SELECT
				*
			FROM
				`users`
			WHERE
				`users`.`email` = '".$username."'
			LIMIT 1
		";

		return $this->connection->query($sql);
	}

	/**
	 * Get User By Id
	 */
	public function getUserById($id) { 
		
		$sql = "
			SELECT
				*
			FROM
				`users`
			WHERE
				`users`.`id` = '".$id."'
			LIMIT 1
		";

		return $this->connection->query($sql);
	}

	public function getCurrentDepartmentOfUserByUserId($id) { }
	public function getUserByDepartmentByDepartmentId($id) { }
	public function getUserByStatus($status) { }
	public function searchUserByName($name) { }

	/**
	 * Get User By Type
	 *
	 * @param String $userType
	 * 
	 * @return Mysqli Query
	 */
	public function getUserByType($userType) { 

		$sql = "
			SELECT
				*
			FROM
				`users`
			WHERE
				`users`.`type` = '".$userType."'
		";

		return $this->connection->query($sql);
	}

	/** 
	 * Get All User Except This User By User Id
	 *
	 * @param Int $id
	 * @param String $email
	 *
	 * @return Myqsli Connection
	 */
	public function getAllUserExceptThisUserByUserId($id, $email)
	{
		$sql = "
			SELECT 
				email 
			FROM 
				users 
			WHERE 
				`users`.`id` != $id
			AND
				`users`.`email`= '".$email."'
		";

		return $this->connection->query($sql);
	}
}