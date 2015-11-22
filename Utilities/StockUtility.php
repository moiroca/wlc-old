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
	public function getStockStatus()
	{
		return [
			Constant::STOCK_GOOD,
			Constant::STOCK_REPAIR,
			Constant::STOCK_REPLACE,
			Constant::STOCK_DELETED,
		];
	}

	/**
	 * Get Stock Item Type
	 *
	 * @return Array
	 */
	public function getStockTypes()
	{
		return [
			Constant::ITEM_MATERIAL,
			Constant::ITEM_TOOL,
			Constant::ITEM_EQUIPMENT,
		];
	}
}
