<?php

/**
 * Class UserUtilitiy
 *
 * @since November 2015
 */
class UserUtility
{
	/**
	 * Get User Status
	 *
	 * @return Array
	 */
	public static function getStatuses()
	{
		return [
			Constant::USER_ACTIVE,
			Constant::USER_DELETED,
		];
	}

	/**
	 * Format Display Of Status
	 *
	 * @return Array
	 */
	public static function formatStatus($status)
	{
		if ($status == Constant::USER_ACTIVE) {
			return '<label class="label label-primary">Active</label>';
		} else if ($status == Constant::USER_DELETED) {
			return '<label class="label label-danger">Deleted</label>';
		}
	}
}
