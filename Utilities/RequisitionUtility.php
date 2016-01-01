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

	/**
	 * Is Approved Requisition
	 * 
	 * @param Array $requisition
	 * @return Boolean
	 */
	public static function isRequisitionApproved($requisition)
	{	
		$isApproved = false;

		if ($requisition['president_id']) {
			
			if ($requisition['department_head_id']) {
				
				if ($requisition['comptroller_id']) {

					if ($requisition['stock_type'] == Constant::ITEM_MATERIAL_EQUIPMENT && $requisition['gsd_officer_id']) {
						
						$isApproved = ($requisition['treasurer_id'] && $requisition['type'] == Constant::REQUISITION_JOB) ? true : false;
					} else if ($requisition['stock_type'] == Constant::ITEM_OFFICE_SUPPLY && $requisition['property_custodian_id']) {
						
						$isApproved = ($requisition['treasurer_id'] && $requisition['type'] == Constant::REQUISITION_JOB) ? true : false;
					}
				}		
			}
		} 

		return $isApproved;
	}
}
