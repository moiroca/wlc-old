<?php

/**
 * Class Requisition Service
 *
 * @since November 2015
 */
class RequisitionService
{
	private $connection = '';

	public function __construct()
	{
		$this->connection = DbConnection::connect()->getConnection();
	}

	/**
	 * Save Requisition
	 * 
	 * @param Array $data
	 */
	public function save($data)
	{

		$datetime_added = new Datetime();
		$datetime_added = $datetime_added->format('Y-m-d H:i:s');
		$requester_id   = Login::getUserLoggedInId();
		$resultQuery = false;

		$query = "INSERT 
					INTO 
						requisitions(
							requester_id,
							purpose,  
							type, 
							status, 
							datetime_added,
							control_identifier,
							area_id) 
					VALUES (
						".$this->connection->real_escape_string($requester_id).",
						'".$this->connection->real_escape_string($data['purpose'])."', 
						'".$this->connection->real_escape_string($data['type'])."',
						'".Constant::REQUISITION_PENDING."',
						'".$datetime_added."',
						'".hexdec(uniqid())."',
						".$this->connection->real_escape_string($data['area_id']).")";

		$insertRequistionQUery = $this->connection->query($query) or die(mysqli_error($this->connection));

		$requisition_id = mysqli_insert_id($this->connection);

		if ($data['items'] && $requisition_id) {
			foreach ($data['items'] as $item) {
				$query = "INSERT 
					INTO 
						stock_requisitions(
							requisition_id,
							stock_id) 
					VALUES (
						".$requisition_id.",
						".(int)$item.")";

				$this->connection->query($query) or die(mysqli_error($this->connection));
			}
		}

		return $insertRequistionQUery;
	}

	/**
	 * Approve Requisition
	 */
	public function approveByPresident($data)
	{
		$updateStatusQuery = "
			UPDATE 
				`requisitions` 
			SET 
				`status`='".Constant::REQUISITION_APPROVED."' 
			WHERE 
				`id`=".$this->connection->real_escape_string($data['requisition_id'])."
		";

		$this->connection->query($updateStatusQuery);

		$updateQuery = "
			UPDATE 
				`approved_requisition` 
			SET 
				`is_approved_by_president`='True' 
			WHERE 
				`requisition_id`='".$this->connection->real_escape_string($data['requisition_id'])."'
			AND
				`approver_type` = '".Constant::USER_GSD_OFFICER."'";		

		$this->connection->query($updateQuery);

		$query = "
			INSERT
				INTO
					`approved_requisition`(
							`requisition_id`,
							`user_id`,
							`approver_type`,
							`approved_datetime`,
							`is_approved_by_president`
						)
				VALUES(
						".$this->connection->real_escape_string($data['requisition_id']).",
						".$data['user_id'].",
						'".$data['approver_type']."',
						'".$data['approved_datetime']."',
						'True'
					)
		";

		$notificationService = new NotificationService();
		$notificationService->saveNotificationsApprovedByPresident([
				'sender_id' => $data['user_id'], 
				'recepient_id' => $data['requesterId']

			]);

		return $this->connection->query($query);
	}
}