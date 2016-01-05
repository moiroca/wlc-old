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
		if ($isJobRequisition) {
			foreach ($data['items'] as $index => $item) {
				$query = "INSERT 
							INTO 
								stock_requisitions(
									requisition_id,
									stock_id,
									changeTo) 
							VALUES (
								".$data['requisition_id'].",
								".$item.",
								'".$data['statuses'][$index]."')";
				
				$this->connection->query($query);
			}
		} else {
			foreach ($data['items'] as $item) {
				$query = "INSERT 
						INTO 
							stock_requisitions(
								requisition_id,
								stock_id) 
						VALUES (
							".$data['requisition_id'].",
							".$item.")";

				$this->connection->query($query);
			}
		}
	}
}