<?php

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';

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
                `stocks`.`type` = '".$type."'
              GROUP BY
                `stocks`.`name`, `stocks`.`datetime_added`");

		return $result;
	}
}