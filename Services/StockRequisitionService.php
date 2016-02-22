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
	public function saveStockRequisition($data, $isJobRequisition = false)
	{	
		$query = "
				INSERT 
				INTO 
					stock_requisitions(
						requisition_id,
						stock_id,
						status) 
				VALUES (
					".$data['requisition_id'].",
					".$data['item'].",
					'".$data['status']."')";

		$this->connection->query($query);
	}
}