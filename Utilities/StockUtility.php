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
			Constant::STOCK_NEW_CONDITION,
			Constant::STOCK_FAIR_CONDITION,
			Constant::STOCK_POOR_CONDITION,
			Constant::STOCK_OBSOLETE
		];

		if (!$notDelete) {
			$statuses[] = Constant::STOCK_DELETED;
		}

		return $statuses;
	}

	/**
	 * Get Job Requisition Stock Item Status 
	 *
	 * @return Array
	 */
	public static function jobRequisitionStatusType()
	{
		$statuses = [
			Constant::STOCK_FOR_REPLACEMENT,
			Constant::STOCK_FOR_REPAIR,
		];

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
