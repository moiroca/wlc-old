<?php

class StockRequisitionService 
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Stock Requisition
	 */
	public function saveStockRequisition($data)
	{
		$result = '';
		
		foreach ($data['items'] as $item) {
			$query = "INSERT 
					INTO 
						stock_requisitions(
							requisition_id,
							stock_id) 
					VALUES (
						".$data['requisition_id'].",
						".$item.")";

			$result = $this->connection->query($query);	
		}

		return $result;
	}
}