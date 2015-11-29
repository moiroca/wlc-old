<?php

/**
 * Class User Service
 *
 * @since November 2015
 */
class UserService
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save User
	 * 
	 * @param Array $area
	 */
	public function save($user)
	{
		$resultQuery = false;
		$date = new DateTime();

		$query = "INSERT 
					INTO 
						users(
							email,
							password,
							lastname,
							firstname,
							middlename,
							type,
							datetime_added
						) 
					VALUES (
						'".$this->connection->real_escape_string($user['username'])."',
						'".md5($this->connection->real_escape_string($user['password']))."',
						'".$this->connection->real_escape_string($user['last_name'])."',
						'".$this->connection->real_escape_string($user['first_name'])."',
						'".$this->connection->real_escape_string($user['middle_name'])."',
						'".$this->connection->real_escape_string($user['user_type'])."',
						'".$date->format('Y-m-d H:i:s')."')";
		
		$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));

		return $resultQuery;
	}
}