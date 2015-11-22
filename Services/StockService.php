<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';

/**
 * Class Stock Service
 *
 * @since Stock Service
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

		for ($i = 0; $i <= $stocks['quantity'] ; $i++) { 

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
							".$stocks['area_id'].", 
							'".$stocks['name']."',
							'".$stocks['type']."',
							'".$stocks['status']."',
							'".$datetime_added."')";
			
			$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));
		}

		return $resultQuery;
	}
}