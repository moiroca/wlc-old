<?php

Class Requisitions extends Base
{
	public $table = 'requisitions';

	public function __construct()
	{
		parent::__construct();
	}

  /**
   * Get Requisition By Id
   */ 
  public function getRequisitionById($requisitionId)
  {
    $sql = "
        SELECT
          *
        FROM
          `requisitions`
        WHERE
          `requisitions`.`id` = $requisitionId
        LIMIT 1
    ";
    
    return $this->connection->query($sql);  
  }

  /**
   * Get Item By Item Id and Requisition Id
   *
   * @param Int $itemId
   * @param Int $requisitionId
   */
  public function getAllRequisitionItemsByItemIdAndRequisitionId($itemId, $requisitionId)
  {
    $sql = "
      SELECT
        *
      FROM 
        `stock_requisitions`
      WHERE
        `stock_requisitions`.`stock_id` = $itemId
      AND
        `stock_requisitions`.`requisition_id` = $requisitionId
      LIMIT 1
    ";

    return $this->connection->query($sql);
  }
	/**
	 * Get All Stocks By Type
	 */
	public function getAllRequesition($type = false, $filters = [])
	{
    $sql = "SELECT 
                `$this->table`.`id` as requisition_id,
                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`control_identifier` as requisition_control_identifier,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `users`.`firstname` as user_firstname,
                `users`.`middlename` as user_middlename,
                `users`.`lastname` as user_lastname,

                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`type` as requisition_type,
                `areas`.`name` as requisition_area_name
              FROM 
                $this->table
              JOIN 
                users 
              ON 
                `users`.`id`=`$this->table`.`requester_id`
              JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              JOIN
                `areas`
              ON
                `$this->table`.`area_id` = `areas`.`id`
              WHERE
                `users`.`id` IS NOT NULL";

    if ($type) {
        $sql .= "
              AND
                `$this->table`.`type` = '".$type."'
          ";
    }

    if (!$type && count($filters) != 0) {

        if (isset($filters['requester_name'])) {
            $sql .= "
              AND
                concat(`users`.`firstname`, `users`.`lastname`, `users`.`middlename`) like '%".$filters['requester_name']."%'
            ";
        } 

        if (isset($filters['requisition_status'])) {
          $statuses = RequisitionUtility::getRequisitionStatuses();
          $status = (isset($statuses[$filters['requisition_status']])) ? $statuses[$filters['requisition_status']] : null;
          
          if ($status) {

              $sql .= "
                AND
                  `requisition_status`.`status` = '".$status."'
              ";
          }
        } 

        if (isset($filters['requisition_type'])) {

            if ($filters['requisition_type'] == 1) {
              $type =  Constant::REQUISITION_JOB;
            } else if ($filters['requisition_type'] == 2) {
              $type = Constant::REQUISITION_ITEM;
            } else {
              $type = null;
            }

            if ($type) {

                $sql .= "
                    AND
                      `$this->table`.`type` = '".$type."'
                ";

            }
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $startDatetime = date_create($filters['start_date'])->format('Y-m-d H:i:s');
            $endDatetime = date_create($filters['end_date'])->format('Y-m-d H:i:s');

            $sql .= "
                AND
                  `$this->table`.`datetime_added` between '".$startDatetime."' and '".$endDatetime."'
            ";
        } else if (isset($filters['start_date']) && !isset($filters['end_date'])) {
            $startDatetime = date_create($filters['start_date'])->format('Y-m-d H:i:s');

            $sql .= "
                AND
                  `$this->table`.`datetime_added` > '".$startDatetime."'
            ";
        } else if (!isset($filters['start_date']) && isset($filters['end_date'])) {
            $endDatetime = date_create($filters['end_date'])->format('Y-m-d H:i:s');
            $sql .= "
                AND
                  `$this->table`.`datetime_added` < '".$endDatetime."'
            ";
        } else {

        }
    }

    $sql .= "
            GROUP BY `$this->table`.`control_identifier`
            ORDER BY
                `requisition_status`.`datetime_added` DESC";
    
    $query = $this->connection->query($sql) or die(mysqli_error($this->connection));
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
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `areas`.`name` as requisition_area_name,
                `users`.`firstname` as user_firstname,
                `users`.`middlename` as user_middlename,
                `users`.`lastname` as user_lastname,
                `departments`.`name` as requisition_department_name,
                `departments`.`id` as requisition_department_id,
                `$this->table`.`datetime_added` as datetime_added
              FROM 
                `$this->table`
              JOIN 
                `users`
              ON
                `users`.`id` = `$this->table`.`requester_id`
              JOIN
                `areas`
              ON
                `$this->table`.`area_id` = `areas`.`id`
              JOIN
                `department_areas`
              ON
                `department_areas`.`area_id` = `$this->table`.`area_id`
              JOIN
                `departments`
              ON
                `departments`.`id` = `department_areas`.`department_id`
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
        WHERE
          `requisition_status`.`requisition_id` = $requisitionId
        AND
          `requisition_status`.`datetime_deleted` IS NULL
     ";

     $requisition = $this->connection->query($sql);

     if ($requisition && 0 != $requisition->num_rows) {
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
          $sql .= " AND `requisition_status`.`status` IN (".implode(',', array_map(function($item) {
              return "'".$item."'";
          }, $status)).")";
      } else {
          $sql .= "
                  AND
                    `requisition_status`.`status` = '".$status."' ";
      }
        
      $sql .= "

            ORDER BY `requisition_status`.`datetime_added` DESC

            LIMIT 1
         ";

      $requisition = $this->connection->query($sql);

      if (0 != $requisition->num_rows) {
        return $requisition->fetch_assoc();
      } else {
        return null;
      }
  }

  /**
   * Get Requisition Items
   */
  public function getRequisitionItems($requisitionId, $stockName)
  {
      $sql = "
          SELECT 
            `stock_requisitions`.`stock_id` as stock_id
          FROM
            `stock_requisitions`
          JOIN
            `stocks`
          ON
            `stocks`.`id` = `stock_requisitions`.`stock_id`
          WHERE
            `stock_requisitions`.`requisition_id` = $requisitionId
          AND
            `stocks`.`name` like '%".trim($stockName)."%'
      ";

      return $this->raw($sql);
  }
  /**
   * Get Requisition By User Type and Requisition Type
   *
   * @param String $userType
   * @param String $requisitionType
   * @param Int $userId
   */
  public function getRequisitionByUserType($userType = null, $requisitionType = null, $userId = null)
  {
      $sql = "SELECT 
                `$this->table`.`id` as requisition_id,
                `$this->table`.`purpose` as requisition_purpose,
                `$this->table`.`control_identifier` as requisition_control_identifier,
                `$this->table`.`datetime_added` as requisition_datetime_added,
                `$this->table`.`type` as requisition_type,
                `users`.`firstname` as user_firstname,
                `users`.`middlename` as user_middlename,
                `users`.`lastname` as user_lastname,
                `areas`.`name` as requisition_area_name,
                `requisition_status`.`status` as requisition_status
              FROM 
                `$this->table`
              JOIN
                `areas`
              ON
                `areas`.`id` = `$this->table`.`area_id`
              JOIN
                `users`
              ON
                `users`.`id` = `$this->table`.`requester_id`";

      if ($userType == Constant::USER_INVENTORY_OFFICER || $userType == Constant::USER_DEPARTMENT_HEAD) {
          $sql .= "
              LEFT JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              WHERE
                `$this->table`.`type` = '".$requisitionType."'
          ";
      } elseif ($userType == Constant::USER_GSD_OFFICER || $userType == Constant::USER_PROPERTY_CUSTODIAN) {

          $sql .= "
              JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              RIGHT JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `$this->table`.`id`
              RIGHT JOIN
                `stocks`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              WHERE
                `requisition_status`.`datetime_deleted` IS NULL
              AND
                `$this->table`.`type` = '".$requisitionType."'
          ";

          if ($requisitionType == Constant::REQUISITION_JOB) {
            
          } else {
            if ($userType == Constant::USER_GSD_OFFICER) {  
              $sql .= "
                AND
                  `stocks`.`type` =  '".Constant::ITEM_MATERIAL_EQUIPMENT."'
              ";
            } else {
              $sql .= "
                AND
                  `stocks`.`type` =  '".Constant::ITEM_OFFICE_SUPPLY."'
              ";
            }
          }


      } elseif ($userType == Constant::USER_TREASURER) {
          $sql .= "
              LEFT JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              WHERE
                `requisition_status`.`status` IN ('".CONSTANT::VERIFIED_BY_GSD_OFFICER."', '".CONSTANT::APPROVED_BY_TREASURER."')
              AND
                `$this->table`.`type` = '".$requisitionType."'
              ORDER BY `requisition_status`.`datetime_added` DESC
          ";
      } elseif ($userType == Constant::USER_COMPTROLLER) {
          $sql .= "
              LEFT JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              WHERE
                `requisition_status`.`status` IN ('".CONSTANT::VERIFIED_BY_GSD_OFFICER."', '".CONSTANT::APPROVED_BY_COMPTROLLER."')
              AND
                `$this->table`.`type` = '".$requisitionType."'
              ORDER BY `requisition_status`.`datetime_added` DESC
          ";
      } elseif ($userType == Constant::USER_PRESIDENT) {
          
          //-----------------------------------
          // Query To Get Requisition APPROVED BY TREASURER AND COMPTROLLER
          // Please Do not delete this query
          //-----------------------------------

          /*
          $sql .= "
              JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              WHERE
                `requisition_status`.`status` 
                IN ('".CONSTANT::APPROVED_BY_COMPTROLLER."', '".CONSTANT::APPROVED_BY_TREASURER."', '".CONSTANT::APPROVED_BY_PRESIDENT."')
              AND
                `$this->table`.`type` = '".$requisitionType."'
              ORDER BY `requisition_status`.`datetime_added` DESC
          ";
          */

          $sql .= "
              JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              WHERE
                `requisition_status`.`status` 
                IN ('".CONSTANT::VERIFIED_BY_GSD_OFFICER."', '".CONSTANT::VERIFIED_BY_PROPERTY_CUSTODIAN."',
                    '".CONSTANT::DECLINED_BY_PRESIDENT."')
              AND
                `$this->table`.`type` = '".$requisitionType."'

          ";

      } else {
          $sql .= "
              JOIN
                `requisition_status`
              ON
                `requisition_status`.`requisition_id` = `$this->table`.`id`
              WHERE
                `$this->table`.`requester_id` = $userId

          ";
      }

      $sql .= "
          GROUP BY `$this->table`.`control_identifier`
      ";

      $requisition = $this->raw($sql);

      if ($requisition && 0 != $requisition->num_rows) {
        return $requisition;
      } else {
        return null;
      }
  }

  /**
   * Check if Item Exists
   */
  public function checkItemExist($requisitionId, $stockId)
  {
     $sql = "
        Select 
          *
        FROM
          `stock_requisitions`
        WHERE
          `requisition_id` = $requisitionId
        AND
          `stock_id` = $stockId
        LIMIT 1
     ";

     $query = $this->raw($sql);

     return ($query && $query->num_rows != 0);
  }
}