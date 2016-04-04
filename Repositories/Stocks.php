<?php

Class Stocks extends Base
{
	public $table = 'stocks';

	public function __construct()
	{
		parent::__construct();
	}

  /**
   * Get All Stocks By Type
   * @param Array $filters
   */
  public function getAllStockForReport($filters = [])
  {
    $sql = "
              SELECT 
                *
              FROM 
                stocks
              JOIN
                `stocks_status`
              ON
                `stocks_status`.`stock_id` = `stocks`.`id`
              WHERE
                `stocks`.`id` IS NOT NULL";

    if ($filters) {
        if (isset($filters['name'])) {
            $sql .= "
              AND `stocks`.`name` like '%".$filters['name']."%'
            ";
        }

        if (isset($filters['status'])) {

            $sql .= "
              AND `stocks_status`.`status` like '%".$filters['status']."%'
            ";
        }

        if (isset($filters['type'])) {

            $sql .= "
              AND `stocks`.`type` like '%".$filters['type']."%'
            ";
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
        }
    }

    $result = $this->raw($sql);

    return $result;
  }

  public function getStockById($id) { }
  public function getCurrentItemType($id) { }
  public function getStockByStatus($status) { }
  public function getStockByControlNumber($controlNumber) { }
  public function getAllRequestedStock() { }
  public function getAllStocksByAreaId($id) { }
  public function getAllStocksByDepartmentId($id) { }
  public function getAllStockByRequisitionId($id) { }

  /**
   * Get All Approved And Received Stock By Job Requisition Id
   *
   * @param Int $requisitionId
   */
  public function getAllApprovedAndReceivedStockByJobRequisitionId($requisitionId) {
    $sql = "
            SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_JOB."'
              AND
                `stock_requisitions`.`status` IN ('".Constant::STOCK_REPAIRED."', '".Constant::STOCK_REPLACED."', '".Constant::STOCK_RECEIVED."')";

     return $this->connection->query($sql);
  }

  /**
   * Get All Approved Stock By Job Requisition Id
   *
   * @param Int $requisitionId
   */
  public function getAllApprovedStockByJobRequisitionId($requisitionId) {
    $sql = "
            SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_JOB."'
              AND
                `stock_requisitions`.`status` IN ('".Constant::STOCK_REPAIRED."', '".Constant::STOCK_REPLACED."')";

     return $this->connection->query($sql);
  }

  /**
   * Get All Approved Stock By Item Requisition Id
   *
   * @param Int $requisitionId
   */
  public function getAllApprovedStockByItemRequisitionId($requisitionId) { 
      $sql = "
            SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_ITEM."'
              AND
                `stock_requisitions`.`status` IN ('".Constant::STOCK_APPROVED."', '".Constant::STOCK_RECEIVED."')";

     return $this->connection->query($sql);
  }

  /**
   * Get First Item Of Requisition
   *
   * @param Int $requisitionId
   */
  public function getFirstItemOfRequisition($requisitionId) 
  { 
    $sql = "
      SELECT
        `stocks`.`id` as stock_id,
        `stocks`.`control_number` as stock_control_number,
        `stocks`.`name` as stock_name,
        `stocks`.`isRequest` as stock_isRequest,
        `stocks`.`unit` as stock_unit,
        `stocks`.`price` as stock_price,
        `stocks`.`type` as stock_type
      FROM
        `stock_requisitions`
      JOIN
        `stocks`
      ON
        `stock_requisitions`.`stock_id` = `stocks`.`id`
      WHERE
        `stock_requisitions`.`requisition_id` = $requisitionId
      LIMIT 1
    ";

    return $this->connection->query($sql);
  }

  /**
   * Get Current Item Location
   *
   * @param Int $itemId
   */
  public function getStockCurrentLocation($itemId)
  {
     $sql = "
        SELECT
          `areas`.`name` as area_name,
          `areas`.`id` as area_id
        FROM
          `area_items`
        JOIN
          `areas`
        ON
          `areas`.`id` = `area_items`.`area_id`
        WHERE
          `area_items`.`item_id` = $itemId
        AND
          `area_items`.`deleted_at` IS NULL
     ";

     return $this->connection->query($sql);
  }

  /**
   * Get All Stock Locations
   *
   * @param Int $itemId
   */
  public function getStockLocations($itemId)
  {
      $sql = "
        SELECT
          `areas`.`name` as area_name,
          `areas`.`id` as area_id,
          `area_items`.`deleted_at` as area_items_deleted_at
        FROM
          `area_items`
        JOIN
          `areas`
        ON
          `areas`.`id` = `area_items`.`area_id`
        WHERE
          `item_id` = $itemId
      ";
     
      return $this->connection->query($sql);
  }

  /**
   * Get Current Item Status
   *
   * @param Int $itemIddeleted_at
   */
  public function getItemCurrentStatus($itemId)
  {
     $sql = "
        SELECT
          *
        FROM
          `stocks_status`
        WHERE
          `stock_id` = $itemId
        AND
          `stocks_status`.`deleted_at` IS NULL
     ";

     return $this->connection->query($sql);
  }

  /**
   * Get All Stock Status
   *
   * @param Int $itemId
   */
  public function getStockStatus($itemId)
  {
      $sql = "
        SELECT
          *
        FROM
          `stocks_status`
        WHERE
          `stock_id` = $itemId
      ";
     
      return $this->connection->query($sql);
  }

	/**
	 * Get All Stocks By Type
	 */
	public function getAllByType($type)
	{
		$result = $this->raw("
              SELECT 
                `stocks`.`name` as stock_name, 
                COUNT(*) as stock_quantity
              FROM 
                stocks 
              WHERE
                `stocks`.`type` = '".$this->connection->real_escape_string($type)."'
              GROUP BY
                `stocks`.`name`, `stocks`.`datetime_added`");

		return $result;
	}

  /**
   * Get Item By Control Number
   */
  public function getByControlNumber($contolNumber)
  {
    $result = $this->raw("
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `areas`.`name` as area_name
              FROM 
                stocks
              JOIN 
                `areas`
              ON
                `areas`.`id` = `stocks`.`area_id`
              WHERE 
                status != 'Deleted'
              AND
                `stocks`.`isRequest` != 'TRUE'
              AND
                `stocks`.`control_number` 
                LIKE '%".$this->connection->real_escape_string($contolNumber)."%'") or die(mysqli_error($this->connection));

    return $result;
  }

  /**
   * Get Item By Control Number
   */
  public function searchItemForJobRequisition($contolNumber)
  {
    $result = $this->raw("
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks_status`.`status` as stock_status
              FROM 
                `stocks`
              JOIN
                `stocks_status`
              ON
                `stocks_status`.`stock_id`=`stocks`.`id`
              WHERE
                `stocks`.`isRequest` != 'TRUE'
              AND
                `stocks_status`.`deleted_at` IS NULL
              AND
                `stocks_status`.`status` != '".Constant::STOCK_OBSOLETE."'
              AND
                `stocks`.`id` NOT IN (
                    SELECT 
                      `stock_id` as id
                    FROM
                      `stock_requisitions`
                    JOIN
                      `requisitions`
                    ON
                      `requisitions`.`id` = `stock_requisitions`.`requisition_id`
                    JOIN
                      `requisition_status`
                    ON
                      `requisitions`.`id` = `requisition_status`.`requisition_id`
                    WHERE
                      `requisition_status`.`status` != '".Constant::RECEIVED_BY_REQUESTER."'
                    AND
                      `requisition_status`.`datetime_deleted` IS NULL
                  )
              AND
                `stocks`.`control_number` 
                LIKE '%".$this->connection->real_escape_string($contolNumber)."%'") or die(mysqli_error($this->connection));

    return $result;
  }

  /**
   * Get All Stocks
   * 
   * @param Array $where
   *    [`field` => value, `value`, `andOrWhere`]
   *    
   */
  public function getStocks($where)
  {
      $sql  = "
        SELECT 
          *
        FROM 
          `stocks`";

      foreach ($where as $index => $param) {
        $operator = ($param['isEqual']) ? '=' : '!=';
        if ($index == 0) {
          $sql .= ' WHERE ';
          $sql .= ' '.$param['field'].' '.$operator.' "'.$this->connection->real_escape_string($param['value']).'" ';
        } else {
          $sql .= ' '.$param['andOrWhere'].' '.$param['field'].' '.$operator.' "'.$this->connection->real_escape_string($param['value']).'"';
        }
      }

      return $this->raw($sql);
  }

  /**
   * Search Item in Stocks By Name For Item Requisition
   *
   * @param Int $requisitionId
   * @param String $itemName
   */
  public function searchItemInStocksByNameForItemRequisition($requisitionId, $itemName)
  {
    # code...
  }

  /**
   * Get Stock By Requisition Id
   *
   * @param int $requisitionId
   */
  public function getStockByRequisitionId($requisitionId, $group = false, $stockName = '')
  {
        $sql = "
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,     
        ";

        if (!$stockName) {
          $sql .= "`stock_requisitions`.`changeTo` as stock_update,";
        }

        if ($group) {
              $sql .= "
                count(*) as count_stocks,
                sum(`stocks`.`price`) total_stock_price
              ";
        }

        $sql .= "
              FROM 
                `stocks`
              ";

        if (!$stockName) {

        $sql  .= "
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`";

        }

        $sql  .="
              WHERE 
                `stocks`.`id` IS NOT NULL
                ";
        if (!$stockName) {
        
        $sql .= "
              AND
                `stock_requisitions`.`requisition_id` = $requisitionId
          ";

        }

        if ($stockName) {
           $sql .= "
              AND
                `stocks`.`name` like '%".$stockName."%'
              AND
                `stocks`.`isRequest` = 'FALSE'
           ";
        } else {
            $sql .= "
              AND
                `stocks`.`isRequest` = 'TRUE'
            ";
        }

        if ($group) {
          $sql .= "
                  GROUP BY
                        `stocks`.`name`
                ";
        }

        // $this->connection->query($sql) or die(mysqli_error($this->connection));
        $result = $this->raw($sql);

        return $result;
  }

  public function getAllStockByRequisitionIdTypeJOB($requisitionId)
  {
      $sql = "
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_JOB."'
                ";

        return $this->raw($sql);
  } 

  /**
   * Search Item By Name
   */
  public function getAllStockByName($stockName)
  { 
      $query = "
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks_status`.`status` as stock_status,
                count(*) as count_stocks,
                `stocks`.`unit` as stock_unit
              FROM 
                `stocks`
              JOIN
                `stocks_status`
              ON
                `stocks_status`.`stock_id` = `stocks`.`id`
              WHERE
                `stocks`.`isRequest` != 'TRUE'
              AND
                `stocks_status`.`deleted_at` IS NULL
              AND
                `stocks_status`.`status` != '".Constant::STOCK_OBSOLETE."'
              AND
                `stocks`.`id` NOT IN (
                    SELECT 
                      `stock_id` as id
                    FROM
                      `stock_requisitions`
                    JOIN
                      `requisitions`
                    ON
                      `requisitions`.`id` = `stock_requisitions`.`requisition_id`
                    JOIN
                      `requisition_status`
                    ON
                      `requisitions`.`id` = `requisition_status`.`requisition_id`
                    WHERE
                      `requisition_status`.`status` != '".Constant::RECEIVED_BY_REQUESTER."'
                    AND
                      `requisition_status`.`datetime_deleted` IS NULL
                  )
              AND
                `stocks`.`name` 
                LIKE '%".$this->connection->real_escape_string(trim($stockName))."%'
              GROUP BY
                `stocks`.`name`, `stocks`.`unit`, `stocks`.`type`";

      // Not Included in a Job Requisition 
      // But if included Job Requisition, 
      // Job Requisition Status Must Be Received by Requester
      // And Stock Status Must not be Obsolete

      /*
      $sql = "
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status,
                count(*) as count_stocks
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_ITEM."'
              GROUP BY
                `stocks`.`name`";
      */
      return $this->connection->query($query); //or die(mysqli_error($this->connection));
  } 

  /**
   * Get All Stock By Item Requisition Id
   * 
   * @param Int $requisitionId
   */
  public function getAllStockByRequisitionIdTypeITEM($requisitionId)
  {
      $sql = "
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status,
                count(*) as count_stocks
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_ITEM."'
              GROUP BY
                `stocks`.`name`";

        return $this->raw($sql);
  } 

  /**
   * Get All Approved Item And Attached Item in Requisition
   *
   * @param Int $int
   */
  public function getAllApprovedAndAttachedItemInRequisition($requisitionId)
  {
     $sql = "
            SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`status` as stock_status,
                count(*) as count_stocks
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              JOIN
                `requisitions`
              ON
                `stock_requisitions`.`requisition_id` = `requisitions`.`id`
              WHERE
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_ITEM."'
              AND
                `stock_requisitions`.`status` = '".Constant::STOCK_APPROVED."'
              GROUP BY
                `stocks`.`name`";

     return $this->connection->query($sql);
  }
  /**
   * Get All Stocks By Type
   */
  public function getAllByStockId($id)
  {
    $result = $this->raw("
              SELECT 
                `stocks`.`name` as stock_name, 
                COUNT(*) as stock_quantity
              FROM 
                stocks 
              WHERE 
                status != 'Deleted'
              AND
                `stocks`.`area_id` = $id
              AND
                `stocks`.`isRequest` != 'TRUE'
              GROUP BY
                `stocks`.`name`");

    return $result;
  }

  /**
   * Get Approved Item By Requisition Id
   */
  public function getApprovedItemInRequisition($requisitionId, $query = false) 
  {
      $sql = "
          SELECT
              `stock_requisitions`.`status` as stock_requisition_status,
              `stocks`.`id` as stock_id,
              `stocks`.`name` as stock_name,
              `stocks`.`control_number` as stock_control_number,
              `stocks`.`price` as stock_price,
              `stocks`.`type` as stock_type,
              `stocks`.`status` as stock_status,
              `areas`.`name` as area_name
          FROM
              `stock_requisitions`
          JOIN
              `stocks`
          ON
              `stocks`.`id` = `stock_requisitions`.`stock_id`
          JOIN
              `areas`
          ON
              `stocks`.`area_id` = `areas`.`id` ";

        $status = 'TRUE';
        if ($query == Constant::STOCK_RECEIVED) {
          $status = 'FALSE';
          $sql .= "
              WHERE
                `stock_requisitions`.`status` = '".Constant::STOCK_RECEIVED."'";
        } else if ($query == Constant::STOCK_APPROVED) {
          $status = 'FALSE';
          $sql .= "
              WHERE
                `stock_requisitions`.`status` = '".Constant::STOCK_APPROVED."'";
        } else {

          $sql .= "
              WHERE
                `stock_requisitions`.`status` in ('".Constant::STOCK_APPROVED."','".Constant::STOCK_RECEIVED."')
              OR
                `stock_requisitions`.`status` IS NULL ";

        }
        
        $sql .="
          AND
              `stock_requisitions`.`requisition_id` = $requisitionId
          AND
              `stocks`.`isRequest` = '".$status."'";

      return $this->raw($sql);
  }
  /**
   * Get Stocks By Stock Name
   */
  public function getStockByStockName($group = false, $stockName = '', $itemIds)
  {
        $sql = "
              SELECT 
                `stocks`.`id` as stock_id,
                `stocks`.`type` as stock_type,
                `stocks`.`control_number` as stock_control_number,
                `stocks`.`name` as stock_name,
                `stocks`.`status` as stock_status,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `areas`.`name` as area_name
        ";

        $sql .= "
              FROM 
                `stocks`
              JOIN 
                `areas`
              ON
                `areas`.`id` = `stocks`.`area_id`
                ";

        if ($itemIds) {
            $itemIds = implode(',', $itemIds);
            
            $sql .= "
              WHERE `stocks`.`id` NOT IN (".$itemIds.")

            ";
        }

        $sql .= "
              AND
                `stocks`.`status` != 'Deleted'
              AND
                `stocks`.`isRequest` = 'FALSE'
              AND
                `stocks`.`name` like '%".$stockName."%'
        ";

        $result = $this->raw($sql);

        if ($result && 0 != $result->num_rows) {
          return $result;
        } else {
          return null;
        }
  }

}