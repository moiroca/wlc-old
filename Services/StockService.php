<?php

/**
 * Class Stock Service
 *
 * @since November 2015
 */
class StockService
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Stock
	 * 
	 * @param Array $stocks
	 */
	public function save($stocks)
	{

		$datetime_added = new Datetime();
		$datetime_added = $datetime_added->format('Y-m-d H:i:s');

		$resultQuery = false;

		for ($i = 1; $i <= $stocks['quantity'] ; $i++) { 

			$query = "INSERT 
						INTO 
							stocks(
								control_number,
								area_id, 
								name, 
								type, 
								status, 
								datetime_added) 
						VALUES (
							".hexdec(uniqid()).",
							".$this->connection->real_escape_string($stocks['area_id']).", 
							'".$this->connection->real_escape_string($stocks['name'])."',
							'".$this->connection->real_escape_string($stocks['type'])."',
							'".$this->connection->real_escape_string($stocks['status'])."',
							'".$datetime_added."')";
			
			$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));
		}

		return $resultQuery;
	}
}