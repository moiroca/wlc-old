<?php

/**
 * Department Area Class
 *
 * @since December 2015
 */
class DepartmentAreaService
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Department Area
	 *
	 * @param Array $data
	 */
	public function save($data) 
	{
		$query = "
			INSERT 
				INTO
					`department_areas`(
							`department_id`,
							`area_id`
						)
				VALUES(
						".$data['department_id'].",
						".$data['area_id']."
					)
		";

		return $this->connection->query($query);
	}
}
