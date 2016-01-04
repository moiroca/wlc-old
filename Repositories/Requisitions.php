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
                `$this->table`.`status` as requisition_status,

                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`type` as requisition_type,
                `$this->table`.`requester_id` as requisition_requester_id,
                `$this->table`.`datetime_approveddeclined_by_president` as requisition_datetime_approveddeclined_by_president,
                `$this->table`.`datetime_approveddeclined_by_gsd_officer` as requisition_datetime_approveddeclined_by_gsd_officer,
                `$this->table`.`datetime_approveddeclined_by_comptroller` as requisition_datetime_approveddeclined_by_comptroller,
                `$this->table`.`datetime_approveddeclined_by_property_custodian` as requisition_datetime_approveddeclined_by_property_custodian,
                `$this->table`.`datetime_approveddeclined_by_department_head` as requisition_datetime_approveddeclined_by_department_head,
                `$this->table`.`datetime_approveddeclined_by_treasurer` as requisition_datetime_approveddeclined_by_treasurer,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `$this->table`.`status` as requisition_status,
                `$this->table`.`president_id` as requisition_president_id,
                `$this->table`.`gsd_officer_id` as requisition_gsd_officer_id,
                `$this->table`.`department_head_id` as requisition_department_head_id,
                `$this->table`.`comptroller_id` as requisition_comptroller_id,
                `$this->table`.`property_custodian_id` as requisition_property_custodian_id,
                `$this->table`.`treasurer_id` as requisition_treasurer_id,
                `areas`.`name` as requisition_area_name
              FROM 
                $this->table
              JOIN 
                users 
              ON 
                `users`.`id`=`$this->table`.`requester_id`
              JOIN
                `areas`
              ON
                `$this->table`.`area_id` = `areas`.`id`
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
                `$this->table`.`status` as requisition_status,

                `$this->table`.`datetime_approveddeclined_by_president` as requisition_datetime_approveddeclined_by_president,
                `$this->table`.`datetime_approveddeclined_by_gsd_officer` as requisition_datetime_approveddeclined_by_gsd_officer,
                `$this->table`.`datetime_approveddeclined_by_comptroller` as requisition_datetime_approveddeclined_by_comptroller,
                `$this->table`.`datetime_approveddeclined_by_property_custodian` as requisition_datetime_approveddeclined_by_property_custodian,
                `$this->table`.`datetime_approveddeclined_by_department_head` as requisition_datetime_approveddeclined_by_department_head,
                `$this->table`.`datetime_approveddeclined_by_treasurer` as requisition_datetime_approveddeclined_by_treasurer,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `$this->table`.`status` as requisition_status,
                `$this->table`.`president_id` as requisition_president_id,
                `$this->table`.`gsd_officer_id` as requisition_gsd_officer_id,
                `$this->table`.`department_head_id` as requisition_department_head_id,
                `$this->table`.`comptroller_id` as requisition_comptroller_id,
                `$this->table`.`property_custodian_id` as requisition_property_custodian_id,
                `$this->table`.`treasurer_id` as requisition_treasurer_id,
                `areas`.`name` as requisition_area_name
              FROM 
                `$this->table`
              JOIN
                `users`
              ON 
                `$this->table`.`gsd_officer_id`=`users`.`id`
              JOIN
                `areas`
              ON
                `$this->table`.`area_id` = `areas`.`id`
              WHERE
                `$this->table`.`comptroller_id` IS NOT NULL
              WHERE
                `$this->table`.`type` = $type
              ";

    $result = $this->raw($sql);

    return $result;
  }

  /**
   * Get All Stocks By Type
   */
  public function getAllRequesitionForApprovalByDepartment($type)
  {
    $sql = "SELECT 
                
              FROM 
                `$this->table`
              JOIN
                `users`
              ON 
                `$this->table`.`gsd_officer_id`=`users`.`id`
              JOIN
                `areas`
              ON
                `$this->table`.`area_id` = `areas`.`id`
              WHERE
                `$this->table`.`comptroller_id` IS NOT NULL
              WHERE
                `$this->table`.`type` = $type
              ";

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
                `$this->table`.`datetime_approveddeclined_by_comptroller` as requisition_datetime_approveddeclined_by_comptroller,
                `$this->table`.`datetime_approveddeclined_by_property_custodian` as requisition_datetime_approveddeclined_by_property_custodian,
                `$this->table`.`datetime_approveddeclined_by_department_head` as requisition_datetime_approveddeclined_by_department_head,
                `$this->table`.`datetime_approveddeclined_by_treasurer` as requisition_datetime_approveddeclined_by_treasurer,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `$this->table`.`status` as requisition_status,
                `$this->table`.`president_id` as requisition_president_id,
                `$this->table`.`gsd_officer_id` as requisition_gsd_officer_id,
                `$this->table`.`department_head_id` as requisition_department_head_id,
                `$this->table`.`comptroller_id` as requisition_comptroller_id,
                `$this->table`.`property_custodian_id` as requisition_property_custodian_id,
                `$this->table`.`treasurer_id` as requisition_treasurer_id,
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

  /**
   * Get Current Requisition Status
   *
   * @param int $requisitionId
   *
   * @return Mix
   */
  public function getCurrentRequisitionStatus($requisitionId)
  {
     $sql = "
        SELECT 
          `requisition_status`.`status` as status
        FROM
          `requisition_status`
        JOIN
          `users`
        ON
          `users`.`id` = `requisition_status`.`user_id`
        WHERE
          `requisition_status`.`requisition_id` = $requisitionId
        ORDER BY
          `requisition_status`.`datetime_added`
        LIMIT 1
     ";

     $requisition = $this->connection->query($sql);

     if (0 != $requisition->num_rows) {
        return $requisition->fetch_assoc()['status'];
     } else {
        return null;
     }
  }

  /**
   * Get All status Of 
   *
   * @param int $requisitionId
   */
  public function getAllRequisitionStatus($requisitionId)
  {
      $sql = "
        SELECT 
          `requisition_status`.`status` as status,
          `users`.`firstname` as user_firstname,
          `users`.`middlename` as user_middlename,
          `users`.`lastname` as user_lastname,
          `users`.`id` as user_id
        FROM
          `requisition_status`
        JOIN
          `users`
        ON
          `users`.`id` = `requisition_status`.`user_id`
        WHERE
          `requisition_status`.`requisition_id` = $requisitionId
        ORDER BY
          `requisition_status`.`datetime_added`
     ";

     $requisition = $this->connection->query($sql);

     if (0 != $requisition->num_rows) {
        return $requisition->fetch_all();
     } else {
        return null;
     }
  }

  /**
   * Get Requisition User From RequisitionId and Status
   *
   * @param int $requisitionId
   * @param String $status
   */
  public function getRequisitionActorByStatus($requisitionId, $status, $or = false)
  {
      $sql = "
        SELECT 
          `users`.`firstname` as user_firstname,
          `users`.`middlename` as user_middlename,
          `users`.`lastname` as user_lastname,
          `users`.`id` as user_id,
          `requisition_status`.`status` as status,
          `requisition_status`.`datetime_added` as datetime_added
        FROM
          `requisition_status`
        JOIN
          `users`
        ON
          `users`.`id` = `requisition_status`.`user_id`
        WHERE
          `requisition_status`.`requisition_id` = $requisitionId";

      if ($or) {
          foreach ($status as $ind => $where) {
              if (0 == $ind) {
                $sql .= " AND ";
              } else {
                $sql  .= " OR ";
              }

              $sql .= " `requisition_status`.`status` = '".$where."' ";
          }
      } else {
          $sql .= "
                  AND
                    `requisition_status`.`status` = '".$status."' ";
      }
        
      $sql .= "
            LIMIT 1
         ";

      $requisition = $this->connection->query($sql);

      if (0 != $requisition->num_rows) {
        return $requisition->fetch_assoc();
      } else {
        return null;
      }
  }
}