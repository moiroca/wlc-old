<?php

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';

Class Requisitions extends Base
{
	public $table = 'requisitions';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Stocks By Type
	 */
	public function getAllRequesition($type)
	{
    $sql = "SELECT 
                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`control_identifier` as requisition_control_identifier,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `$this->table`.`datetime_provided` as requisition_datetime_provided,
                `users`.`firstname` as user_firstname,
                `users`.`middlename` as user_middlename,
                `users`.`lastname` as user_lastname,
                `$this->table`.`status` as requisition_status
              FROM 
                $this->table
              JOIN 
                users 
              ON 
                `users`.`id`=`$this->table`.`requester_id`
              WHERE
                `$this->table`.`type` = '".$type."'";

		$result = $this->raw($sql);

		return $result;
	}
}