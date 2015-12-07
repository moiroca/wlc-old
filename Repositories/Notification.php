<?php

/**
 * Class Notifications
 */
class Notification extends Base
{
	public $table = 'notifications';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Notifications By Sender Id
	 */ 
	public function getAllBySenderId($senderId)
	{
		$sql = "
			SELECT 
				`notifications`.`id` as notification_id,
				`notifications`.`msg` as notification_msg,
				`notifications`.`datetime_sent` as notification_datetime_sent,
				`users`.`firstname` as user_firstname,
				`users`.`lastname` as user_lastname
			FROM
				`notifications`
			JOIN
				`users`
			ON
				`users`.`id` = `notifications`.`recepient_id`
			WHERE
				`notifications`.`sender_id` = $senderId
		";

		return $this->raw($sql);
	}

	/**
	 * Get Recepient By Recepient Id
	 *
	 * @param $recepientId
	 * 
	 * @return Query
	 */
	public function getAllByRecepient($recepientId)
	{
		$sql = "
			SELECT 
				`notifications`.`id` as notification_id,
				`notifications`.`msg` as notification_msg,
				`notifications`.`datetime_sent` as notification_datetime_sent,
				`users`.`firstname` as user_firstname,
				`users`.`lastname` as user_lastname
			FROM
				`notifications`
			JOIN
				`users`
			ON
				`users`.`id` = `notifications`.`sender_id`
			WHERE
				`notifications`.`recepient_id` = $recepientId
			AND
				`notifications`.`viewed` = '".Constant::NOTIFICATION_NOT_VIEWED."'
		";

		return $this->raw($sql);
	}

	/**
	 * Get Notifications By Sender Id And Recepient Id
	 *
	 * @param Int $recepientId
	 * @param Int $senderId
	 * 
	 * @return Query
	 */
	public function getAllByRecepientAndSender($recepientId, $senderId)
	{
		$sql = "
			SELECT 
				`notifications`.`id` as notification_id,
				`notifications`.`msg` as notification_msg,
				`notifications`.`datetime_sent` as notification_datetime_sent,
				`users`.`firstname` as user_firstname,
				`users`.`lastname` as user_lastname
			FROM
				`notifications`
			JOIN
				`users`
			ON
				`users`.`id` = `notifications`.`sender_id`
			WHERE
				`notifications`.`recepient_id` = $recepientId
			AND
				`notifications`.`sender_id` = $senderId
			AND
				`notifications`.`viewed` = '".Constant::NOTIFICATION_NOT_VIEWED."'
		";

		return $this->raw($sql);
	}
}