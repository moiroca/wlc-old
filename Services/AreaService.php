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
		
		$resultQuery = $this->connection->query($query);

		$area_id = mysqli_insert_id($this->connection);

		$departmentAreaService = new DepartmentAreaService();

		return $departmentAreaService->save([
				'department_id' => $area['department_id'],
				'area_id'	=> $area_id
			]);
	}
}