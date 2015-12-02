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
                `$this->table`.`status` as requisition_status
              FROM 
                `$this->table`
              JOIN
                `users`
              ON 
                `$this->table`.`gsd_officer_id`=`users`.`id`
              WHERE
                `$this->table`.`president_id` IS NULL";

    $result = $this->raw($sql);

    return $result;
  }

  /**
   * Get Requisition By Control Identifier
   */
  public function getRequisitionByControlIdentifier($controlIdentifier)
  {
    $sql = "SELECT 
                `$this->table`.`id` as requisition_id,
                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`type` as requisition_type,
                `$this->table`.`requester_id` as requisition_requester_id,
                `$this->table`.`control_identifier` as requisition_control_identifier,
                `$this->table`.`datetime_approveddeclined_by_president` as requisition_datetime_approveddeclined_by_president,
                `$this->table`.`datetime_approveddeclined_by_gsd_officer` as requisition_datetime_approveddeclined_by_gsd_officer,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `$this->table`.`status` as requisition_status,
                `$this->table`.`president_id` as requisition_president_id,
                `$this->table`.`gsd_officer_id` as requisition_gsd_officer_id,
                `areas`.`name` as requisition_area_name
              FROM 
                `$this->table`
              JOIN
                `areas`
              ON
                `$this->table`.`area_id` = `areas`.`id`
              WHERE
                `$this->table`.`control_identifier` = $controlIdentifier";

    $result = $this->raw($sql);

    return $result;
  }
}