<?php

/**
 * Class Area Service
 *
 * @since November 2015
 */
class AreaService
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Area
	 * 
	 * @param Array $area
	 */
	public function save($area)
	{
		$resultQuery = false;

		$query = "INSERT 
					INTO 
						areas(name) 
					VALUES (
						'".$this->connection->real_escape_string($area['name'])."')";
		
		$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));

		return $resultQuery;
	}
}