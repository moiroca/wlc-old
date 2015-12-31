<?php

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

	/**
	 * Save Department Heads
	 */
	public function saveDepartmentHead($data)
	{
		$sql = "INSERT 
					INTO
						`department_heads`
						(`user_id`, `department_id`, `datetime_added`)
					VALUES (
							".$data['user_id'].",
							".$data['department_id'].",
							'".date_create()->format('Y-m-d H:i:s')."'
						)";

		$resultQuery = $this->connection->query($sql) or die(mysqli_error($this->connection));

		return $resultQuery;
	}

	public function updateDepartmentHead($data)
	{
		$date = date_create()->format('Y-m-d H:i:s');

		$sql = "UPDATE 
					`department_heads`
				SET
					`datetime_deleted` = '".$date."'
				WHERE 
					`user_id` = ".$data['user_id']."
				AND
					`department_id` = ".$data['department_id']."
				AND
					`datetime_deleted` IS NULL
				";

		$resultQuery = $this->connection->query($sql) or die(mysqli_error($this->connection));

		return $resultQuery;
	}
}