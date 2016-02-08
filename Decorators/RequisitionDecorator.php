<?php

class RequisitionDecorator {

	/**
	 *
	 */
	public static function status($status)
	{
		if (self::declinedStatus($status)) {
			return "<label class='label label-danger'>".$status."</label>";
		} else if (self::approvedStatus($status)) {
			return "<label class='label label-success'>".$status."</label>";
		} else {
			return "<label class='label label-info'> Pending For Approval. </label>";
		}
	}

	/**
	 * Declined Requisition
	 *
	 * @param String $status
	 */
	private static function declinedStatus($status) {
		return in_array($status, [
				Constant::DECLINED_BY_PRESIDENT,
				Constant::DECLINED_BY_GSD_OFFICER,
				Constant::DECLINED_BY_PROPERTY_CUSTODIAN
			]);
	}

	/**
	 * Approved Requisition
	 *
	 * @param String $status
	 */
	private static function approvedStatus($status) {
		return in_array($status, [
				Constant::APPROVED_BY_PRESIDENT,
				Constant::VERIFIED_BY_GSD_OFFICER,
				Constant::VERIFIED_BY_PROPERTY_CUSTODIAN,
				Constant::RELEASED_BY_PROPERTY_CUSTODIAN,
				Constant::RELEASED_BY_GSD_OFFICER,
				Constant::RECEIVED_BY_REQUESTER,
				Constant::ITEM_VERIFIED_BY_PRESIDENT
			]);
	}
}

?>