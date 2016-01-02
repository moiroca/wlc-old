<?php
/**
* Notification Service
* 
* @since November
*/
class NotificationService
{
	public $connection;

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Update Notification Status to Viewed
	 */
	public function updateNotificationToViewed($notificationId)
	{
		$datetime = date_create()->format('Y-m-d H:i:s');

		$sql = "
			UPDATE 
				`notifications`
			SET
				`notifications`.`viewed` = '".Constant::NOTIFICATION_VIEWED."',
				`notifications`.`datetime_viewed` = '".$datetime."'
			WHERE
				`notifications`.`id` = $notificationId
		";

		return $this->connection->query($sql);
	}

	/** 
	 * Insert New Notifications
	 */
	public function saveNotification($data)
	{
		$date = new Datetime();

		$sql = "
			INSERT 
				INTO 
				 	`notifications` (
				 		`sender_id`,
				 		`recepient_id`,
				 		`datetime_sent`,
				 		`msg`
				 	) 
				 VALUES (
				 	".$data['sender_id'].", 
				 	".$data['recepient_id'].",
				 	'".$date->format('Y-m-d H:i:s')."',
				 	'".$data['msg']."'
				 	)";

		$this->connection->query($sql) or die(mysqli_error($this->connection));;		
	}
}

?>