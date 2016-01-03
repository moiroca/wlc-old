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

	public function getUserDepartmentByRequesterId($id)
	{
		$sql = "
			SELECT
				`departments`.`name` as department_name
			FROM
				`departments`
			JOIN
				`users`
			ON
				`users`.`department_id` = `departments`.`id`
			JOIN
				`requisitions`
			ON
				`requisitions`.`requester_id` = `users`.`id`
			WHERE
				`users`.`id` = $id
		";

		return $this->raw($sql);
	}

	public function getUserDepartmentByUserId($id)
	{
		$sql = "
			SELECT
				`departments`.`name` as department_name
			FROM
				`departments`
			JOIN
				`users`
			ON
				`users`.`department_id` = `departments`.`id`
			WHERE
				`users`.`id` = $id
		";

		return $this->raw($sql);
	}
}