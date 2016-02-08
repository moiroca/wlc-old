<?php

/**
 * Departments Class
 */
Class Area extends Base
{
	public $table = 'areas';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Area With Department
	 */
	public function getAllAreaWithDeparment($areaId = false)
	{
		$query = "
			SELECT 
				`areas`.`name` as area_name,
				`areas`.`id` as area_id,
				`departments`.`name` as department_name,
				`departments`.`id` as department_id
			FROM 
				`department_areas`
			JOIN
				`departments`
			ON
				`departments`.`id` = `department_areas`.`department_id`
			JOIN
				`areas`
			ON
				`areas`.`id` = `department_areas`.`area_id`
			WHERE
				`areas`.`id` is not null
			AND
				`areas`.`deleted_at` is null
		";

		if ($areaId) {
			$query .= "
				AND
					`areas`.`id` = $areaId
			";
		}

		return $this->connection->query($query);
	}

	public function getAllAreaByDepartmentId($id)
	{
		$sql = "
			SELECT 
				`areas`.`id` as area_id,
				`areas`.`name` as area_name
			FROM
				`areas`
			JOIN
				`department_areas`
			ON 
				`department_areas`.`area_id` = `areas`.`id` 
			WHERE
				`department_areas`.`department_id` = $id
		";

		return $this->connection->query($sql);
	}
}