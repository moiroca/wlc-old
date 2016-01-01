<?php

/**
 * Class StockUtility
 *
 * @since November 2015
 */
class StockUtility
{
	
	/**
	 * Get Stock Item Status
	 *
	 * @return Array
	 */
	public static function getStockStatus($notDelete = true)
	{
		$statuses = [
			Constant::STOCK_GOOD,
			Constant::STOCK_REPAIR,
			Constant::STOCK_REPLACE,
		];

		if (!$notDelete) {
			$statuses[] = Constant::STOCK_DELETED;
		}

		return $statuses;
	}

	/**
	 * Get Stock Item Type
	 *
	 * @return Array
	 */
	public static function getStockTypes()
	{
		return [
			Constant::ITEM_MATERIAL_EQUIPMENT,
			Constant::ITEM_OFFICE_SUPPLY,
		];
	}
}
