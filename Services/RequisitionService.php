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
	public function approve($data)
	{
		if ($data['approver_type'] == Constant::USER_GSD_OFFICER) {
			$updateStatusQuery = "
				UPDATE 
					`requisitions` 
				SET 
					`status`='".Constant::REQUISITION_APPROVED."',
					`datetime_approveddeclined_by_gsd_officer` = '".date_create()->format('Y-m-d H:i:s')."',
					`gsd_officer_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requistion_id']."
			";
		} else {
			$updateStatusQuery = "
				UPDATE 
					`requisitions` 
				SET 
					`status`='".Constant::REQUISITION_APPROVED."',
					`datetime_approveddeclined_by_president` = '".date_create()->format('Y-m-d H:i:s')."',
					`president_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requisition_id']."
			";
		}

		return $this->connection->query($updateStatusQuery);
	}


}