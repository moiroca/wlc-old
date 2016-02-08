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
                status != 'Deleted'
              AND
                `stocks`.`type` = '".$this->connection->real_escape_string($type)."'
              AND
                `stocks`.`isRequest` != 'TRUE'
              GROUP BY
                `stocks`.`name`");

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
                `stocks`.`status` as stock_status,
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
   * Get All Stocks
   * 
   * @param Array $where
   *    [`field` => value, `value`, `andOrWhere`]
   *    
   */
  public function getStocks($where)
  {
      $sql  = "SELECT 
                `stocks`.`control_number` as stock_control_number, 
                `stocks`.`name` as stock_name, 
                `stocks`.`status` as stock_status
              FROM 
                stocks";

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
                `stocks`.`status` as stock_status,
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
                `stocks`.`status` != 'Deleted'
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
                `stocks`.`status` as stock_status,
                `stocks`.`price` as stock_price,
                `stocks`.`isRequest` as stock_isRequest,
                `stocks`.`unit` as stock_unit,
                `stock_requisitions`.`changeTo` as stock_update
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
                `stocks`.`status` != 'Deleted'
              AND
                `stock_requisitions`.`requisition_id` = $requisitionId
              AND
                `requisitions`.`type` = '".Constant::REQUISITION_JOB."'
                ";

       return $this->raw($sql);
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