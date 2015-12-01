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
	public function getAllAreaWithDeparment()
	{
		$query = "
			SELECT 
				`areas`.`name` as area_name,
				`areas`.`id` as area_id,
				`departments`.`name` as department_name
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
		";

		return $this->connection->query($query);
	}
}