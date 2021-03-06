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
								price,
								unit,
								isRequest,
								datetime_added) 
						VALUES (
							".time().",
							'".$this->connection->real_escape_string($stocks['name'])."',
							'".$this->connection->real_escape_string($stocks['type'])."',
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

	/**
	 * Save Stock
	 *
	 * @param Array $data
	 *
	 * @return Int $stockId
	 */
	public function saveStock($data)
	{
		$datetime_added = date_create()->format('Y-m-d H:i:s');
		$isRequired = (isset($data['isRequest']) && $data['isRequest']) ? 'TRUE' : 'FALSE';

		$query = "
			INSERT 
			INTO 
				stocks(
					control_number,
					name, 
					type,
					price,
					unit,
					isRequest,
					datetime_added) 
			VALUES (
				'".$this->connection->real_escape_string($data['control_number'])."',
				'".$this->connection->real_escape_string($data['name'])."',
				'".$this->connection->real_escape_string($data['type'])."',
				'".$this->connection->real_escape_string($data['price'])."',
				'".$this->connection->real_escape_string($data['unit'])."',
				'".$isRequired."',
				'".$datetime_added."')";
		
		$resultQuery = $this->connection->query($query) or die(mysqli_error($this->connection));
		return mysqli_insert_id($this->connection);
	}

	/**
	 * Save Stock Location
	 *
	 * @param Int $itemId
	 * @param Int $areaId
	 * @param Int $actorId
	 */
	public function saveStockLocation($itemId, $areaId, $actorId)
	{
		$createdAt = date_create()->format('Y-m-d H:i:s');

		$sql = "
			INSERT
			INTO
				`area_items`(`area_id`, `item_id`, `created_at`, `actor_id`)
			VALUES
				($areaId, $itemId, '".$createdAt."', $actorId)
		";

		return $this->connection->query($sql) or die(mysqli_error($this->connection));
	}

	/**
	 * Update Stock Location
	 *
	 * @param Int $itemId
	 * @param Int $areaId
	 */
	public function updateStockLocation($itemId, $areaId)
	{
		$sql = "
			UPDATE
				`area_items`
			SET
				`area_items`.`deleted_at` = '".date_create()->format('Y-m-d H:i:s')."'
			WHERE
				`area_items`.`item_id` = $itemId
			AND
				`area_items`.`area_id` = $areaId
		";

		return $this->connection->query($sql);
	}

	/**
	 * Save Stock Status
	 *
	 * @param Int $itemId
	 * @param String $status
	 * @param Int $actorId
	 */
	public function saveStockStatus($itemId, $status, $actorId)
	{
		$createdAt = date_create()->format('Y-m-d H:i:s');

		$sql = "
			INSERT
			INTO
				`stocks_status`(`stock_id`,`status`,`actor_id`,`created_at`)
			VALUES
				($itemId, '".$status."', $actorId, '".$createdAt."')
		";

		return $this->connection->query($sql) or die(mysqli_error($this->connection));
	}

	/**
	 * Update Stock Status
	 *
	 * @param Int $itemId
	 * @param String $status
	 */
	public function updateStockStatus($itemId)
	{
		$sql = "
			UPDATE
				`stocks_status`
			SET
				`stocks_status`.`deleted_at` = '".date_create()->format('Y-m-d H:i:s')."'
			WHERE
				`stocks_status`.`stock_id` = $itemId
			AND
				`stocks_status`.`deleted_at` IS NULL
		";

		return $this->connection->query($sql);
	}

	/**
	 * Save Replaced Item
	 *
	 * @param Int $replacedItemId
	 * @param Int $replacementItemId
	 */
	public function saveReplacementItem($replacedItemId, $replacementItemId)
	{
		$sql = "
			INSERT
			INTO
				`item_replacement`
				(replaced_item_id, replacement_item_id, created_at)
			VALUES
				($replacedItemId, $replacementItemId, '".date_create()->format('Y-m-d H:i:s')."')
		";

		return $this->connection->query($sql);
	}
}