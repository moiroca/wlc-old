<?php

/**
 * Class RequsitionUtility
 *
 * @since November 2015
 */
class RequisitionUtility
{
	/**
	 * Get Requisitions Types
	 *
	 * @return Array
	 */
	public static function getRequisitionTypes()
	{
		return [
			Constant::REQUISITION_JOB,
			Constant::REQUISITION_ITEM,
		];
	}

	/**
	 * Get Requisitions Statuses
	 *
	 * @return Array
	 */
	public static function getRequisitionStatuses()
	{
		return [
			Constant::REQUISITION_APPROVED,
			Constant::REQUISITION_PENDING,
			Constant::REQUISITION_ONGOING,
			Constant::REQUISITION_FINISHED,
		];
	}
}
