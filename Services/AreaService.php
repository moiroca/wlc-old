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

		return $this->saveAreaInDepartment($area_id, $area['department_id']);
	}

	/**
	 * Save Area in Department
	 */
	public function saveAreaInDepartment($areaId, $departmentId)
	{
		$departmentAreaService = new DepartmentAreaService();

		return $departmentAreaService->save([
				'department_id' => $departmentId,
				'area_id'	=> $areaId
			]);
	}
	/**
	 * Delete Area
	 *
	 * @param Int $areaId
	 */
	public function delete($areaId)
	{
		$sql = "
			DELETE
			FROM
				`areas`
			WHERE
				`areas`.`id` = $areaId
		";

		$this->connection->query($sql);
	}

	/**
	 * Delete Area in Department
	 *
	 * @param Int $areaId
	 */
	public function deleteAreaFromDepartment($areaId)
	{
		$sql = "
			DELETE
			FROM
				`department_areas`
			WHERE
				`department_areas`.`area_id` = $areaId
		";

		$this->connection->query($sql);
	}
}