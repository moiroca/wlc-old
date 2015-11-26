<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';

/**
 * Class Department Service
 *
 * @since November 2015
 */
class DepartmentService
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Department
	 * 
	 * @param Array $department
	 */
	public function save($department)
	{
		$resultQuery = false;
		
		$query = "INSERT 
					INTO 
						departments(name) 
					VALUES (
						'".$this->connection->real_escape_string($department['name'])."')";
		
		$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));

		return $resultQuery;
	}
}