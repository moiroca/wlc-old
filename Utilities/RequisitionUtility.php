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

	public static function isRequisitionActionedByDepartmentHead($status, $isApproved = false)
	{
		if ($isApproved) {
			return in_array($status, [
					Constant::NOTED_BY_DEPARTMENT_HEAD,
					Constant::VERIFIED_BY_PROPERTY_CUSTODIAN,
					Constant::VERIFIED_BY_GSD_OFFICER,
					Constant::APPROVED_BY_COMPTROLLER,
					Constant::APPROVED_BY_PRESIDENT,
					Constant::APPROVED_BY_TREASURER,
				]);
		} else {
			return in_array($status, [
					Constant::NOTED_BY_DEPARTMENT_HEAD,
					Constant::VERIFIED_BY_PROPERTY_CUSTODIAN,
					Constant::VERIFIED_BY_GSD_OFFICER,
					Constant::APPROVED_BY_COMPTROLLER,
					Constant::APPROVED_BY_PRESIDENT,
					Constant::APPROVED_BY_TREASURER,

					Constant::DECLINED_BY_DEPARTMENT_HEAD,
					Constant::DECLINED_BY_PROPERTY_CUSTODIAN,
					Constant::DECLINED_BY_GSD_OFFICER,
					Constant::DECLINED_BY_COMPTROLLER,
					Constant::DECLINED_BY_PRESIDENT,
					Constant::DECLINED_BY_TREASURER,
				]);
		}
	}

	public function isRequisitionActionByTreasurer($status)
	{
		return in_array($status, [
					Constant::VERIFIED_BY_PROPERTY_CUSTODIAN,
					Constant::VERIFIED_BY_GSD_OFFICER,
					Constant::APPROVED_BY_COMPTROLLER,
					Constant::APPROVED_BY_PRESIDENT,
					Constant::APPROVED_BY_TREASURER,
				]);
	}

	public static function isRequisitionActionedByPropertyCustodianOrGSDOfficer($status, $isApproved = false)
	{
		if ($isApproved) {
			
			return in_array($status, [
					Constant::VERIFIED_BY_PROPERTY_CUSTODIAN,
					Constant::VERIFIED_BY_GSD_OFFICER,
					Constant::APPROVED_BY_COMPTROLLER,
					Constant::APPROVED_BY_PRESIDENT,
					Constant::APPROVED_BY_TREASURER,
					Constant::RELEASED_BY_PROPERTY_CUSTODIAN,
					Constant::RELEASED_BY_GSD_OFFICER,
					Constant::RECEIVED_BY_REQUESTER,
					Constant::ITEM_VERIFIED_BY_PRESIDENT
				]);
		} else {
		
			return in_array($status, [
					Constant::VERIFIED_BY_PROPERTY_CUSTODIAN,
					Constant::VERIFIED_BY_GSD_OFFICER,
					Constant::APPROVED_BY_COMPTROLLER,
					Constant::APPROVED_BY_PRESIDENT,
					Constant::APPROVED_BY_TREASURER,
					Constant::RELEASED_BY_PROPERTY_CUSTODIAN,
					Constant::RELEASED_BY_GSD_OFFICER,
					Constant::RECEIVED_BY_REQUESTER,
					Constant::ITEM_VERIFIED_BY_PRESIDENT,

					Constant::DECLINED_BY_PROPERTY_CUSTODIAN,
					Constant::DECLINED_BY_GSD_OFFICER,
					Constant::DECLINED_BY_COMPTROLLER,
					Constant::DECLINED_BY_PRESIDENT,
					Constant::DECLINED_BY_TREASURER,
				]);
		}
	}

	public static function isRequisitionActionedByComptroller($status)
	{
		return in_array($status, [
				Constant::APPROVED_BY_COMPTROLLER,
				Constant::APPROVED_BY_PRESIDENT,

				Constant::DECLINED_BY_COMPTROLLER,
				Constant::DECLINED_BY_PRESIDENT,
			]);
	}

	public static function isRequisitionActionedByTreasurer($status)
	{
		return in_array($status, [
				Constant::APPROVED_BY_TREASURER,
				Constant::APPROVED_BY_PRESIDENT,

				Constant::DECLINED_BY_TREASURER,
				Constant::DECLINED_BY_PRESIDENT,
			]);
	}

	public static function isRequisitionActionedByPresident($status)
	{
		return in_array($status, [
				Constant::APPROVED_BY_PRESIDENT,

				Constant::DECLINED_BY_PRESIDENT,
			]);
	}
}
