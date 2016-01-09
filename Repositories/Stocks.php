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

        if ($group) {
              $sql .= "
                count(*) as count_stocks,
                sum(`stocks`.`price`) total_stock_price
              ";
        }

        $sql .= "
              FROM 
                `stocks`
              JOIN
                `stock_requisitions`
              ON
                `stock_requisitions`.`stock_id` = `stocks`.`id`
              WHERE 
                `stocks`.`status` != 'Deleted'
              AND
                `stock_requisitions`.`requisition_id` = $requisitionId
                ";

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
                `stocks`.`isRequest` = 'FALSE'
            ";
        }

        if ($group) {
          $sql .= "
                  GROUP BY
                        `stocks`.`name`
                ";
        }

        // die($sql);
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
                `stocks`.`unit` as stock_unit 
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
   * Get all stock by area id
   */
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
}