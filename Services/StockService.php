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
	public function save($stocks, $isRequisition = false, $stockIds = [])
	{

		$datetime_added = new Datetime();
		$datetime_added = $datetime_added->format('Y-m-d H:i:s');

		$resultQuery = false;

		for ($i = 1; $i <= $stocks['quantity'] ; $i++) { 

			$isRequired = ($stocks['isRequest']) ? 'TRUE' : 'FALSE';

			$query = "INSERT 
						INTO 
							stocks(
								control_number,
								name, 
								type, 
								status, 
								price,
								area_id,
								unit,
								isRequest,
								datetime_added) 
						VALUES (
							".time().",
							'".$this->connection->real_escape_string($stocks['name'])."',
							'".$this->connection->real_escape_string($stocks['type'])."',
							'".$this->connection->real_escape_string($stocks['status'])."',
							'".$this->connection->real_escape_string($stocks['price'])."',
							'".$this->connection->real_escape_string($stocks['area_id'])."',
							'".$this->connection->real_escape_string($stocks['unit'])."',
							'".$isRequired."',
							'".$datetime_added."')";
			
			$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));

			$stockIds[] = mysqli_insert_id($this->connection);
		}

		if ($isRequisition) { return $stockIds; } else { return $resultQuery; }
	}
}