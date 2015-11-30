<?php

Class ItemRequisition extends Base
{
	public $table = 'requisitions';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Requisition By Control Number
	 */
	public function getAllRequesitionByControlNumber($controlIdentifier)
	{
    $sql = "SELECT 
                `$this->table`.`id` as requisition_id,
                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`control_identifier` as requisition_control_identifier,
                `$this->table`.`datetime_added` as requisition_datetime_added,
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
                `$this->table`.`type` = '".Constant::REQUISITION_ITEM."'
              AND
                `$this->table`.`control_identifier` = '".$this->connection->real_escape_string($controlIdentifier)."'";

		$result = $this->raw($sql);

		return $result;
	}
}