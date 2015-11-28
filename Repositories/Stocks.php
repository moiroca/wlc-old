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
                COUNT(*) as stock_quantity,
                `areas`.`name` as area_name
              FROM 
                stocks 
              JOIN 
                areas 
              ON `areas`.`id`=`stocks`.`area_id`
              WHERE 
                status != 'Deleted'
              AND
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
                `stocks`.`status` as stock_status,
                `areas`.`name` as area_name
              FROM 
                stocks 
              JOIN 
                areas 
              ON `areas`.`id`=`stocks`.`area_id`
              WHERE 
                status != 'Deleted'
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
                `stocks`.`status` as stock_status,
                `areas`.`name` as area_name
              FROM 
                stocks 
              JOIN 
                areas 
              ON `areas`.`id`=`stocks`.`area_id`";

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
}