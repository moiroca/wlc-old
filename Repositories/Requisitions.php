<?php

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
                `$this->table`.`type` = '".$type."'";

		$result = $this->raw($sql);

		return $result;
	}

  /**
   * Get All Stocks By Type
   */
  public function getAllRequesitionForApprovalByPresident($type)
  {
    $sql = "SELECT 
                `$this->table`.`id` as requisition_id,
                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`type` as requisition_type,
                `$this->table`.`requester_id` as requisition_requester_id,
                `$this->table`.`control_identifier` as requisition_control_identifier,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `users`.`firstname` as user_firstname,
                `users`.`middlename` as user_middlename,
                `users`.`lastname` as user_lastname,
                `approved_requisition`.`approver_type` as approver_type,
                `approved_requisition`.`id` as approved_requisition_id,
                `$this->table`.`status` as requisition_status
              FROM 
                `$this->table`
              INNER JOIN 
                `approved_requisition`
              ON 
                `approved_requisition`.`requisition_id`=`$this->table`.`id`
              JOIN
                `users`
              ON 
                `users`.`id`=`approved_requisition`.`user_id`
              AND 
                `approved_requisition`.`approver_type` = '".Constant::USER_GSD_OFFICER."'
              AND
                `approved_requisition`.`is_approved_by_president` = 'False'
              ";

    $result = $this->raw($sql);

    return $result;
  }
}