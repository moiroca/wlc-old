<?php

/**
 * Departments Class
 */
Class Department extends Base
{
	public $table = 'departments';

	public function __construct()
	{
		parent::__construct();
	}

	public function getDepartmentHeadByDepartmentId($departmentId) 
	{
		$sql = "SELECT 
					`users`.`firstname` as user_firstname,
					`users`.`lastname` as user_lastname,
					`users`.`id` as user_id
				FROM 
					`users`
				JOIN
					`department_heads`
				ON
					`department_heads`.`user_id` = `users`.`id`
				WHERE
					`department_heads`.`department_id` = $departmentId
				AND
					`department_heads`.`datetime_deleted` IS NULL
				";

		return $this->raw($sql);
	}

	public function getDepartmentHeads($departmentId)
	{
		$sql = "SELECT 
					`users`.`firstname` as user_firstname,
					`users`.`lastname` as user_lastname,
					`users`.`id` as user_id
				FROM 
					`users`
				JOIN
					`department_heads`
				ON
					`department_heads`.`user_id` = `users`.`id`
				WHERE
					`department_heads`.`department_id` = $departmentId
				AND
					`department_heads`.`datetime_deleted` IS NULL
				";

		return $this->raw($sql);
	}
}