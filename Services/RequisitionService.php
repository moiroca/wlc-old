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

		return $requisition_id;
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
					`status`='".Constant::VERIFIED_BY_GSD_OFFICER."',
					`datetime_approveddeclined_by_gsd_officer` = '".date_create()->format('Y-m-d H:i:s')."',
					`gsd_officer_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requisition_id']."
			";
		} elseif ($data['approver_type'] == Constant::USER_PRESIDENT) {
			$updateStatusQuery = "
				UPDATE 
					`requisitions` 
				SET 
					`status`='".Constant::APPROVED_BY_PRESIDENT."',
					`datetime_approveddeclined_by_president` = '".date_create()->format('Y-m-d H:i:s')."',
					`president_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requisition_id']."
			";
		} else if ($data['approver_type'] == Constant::USER_TREASURER) {
			# code...
		} elseif ($data['approver_type'] == Constant::USER_PROPERTY_CUSTODIAN) {
			$updateStatusQuery = "
				UPDATE 
					`requisitions` 
				SET 
					`status`='".Constant::VERIFIED_BY_PROPERTY_CUSTODIAN."',
					`datetime_approveddeclined_by_property_custodian` = '".date_create()->format('Y-m-d H:i:s')."',
					`property_custodian_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requisition_id']."
			";
		} elseif ($data['approver_type'] == Constant::USER_COMPTROLLER) {
			$updateStatusQuery = "
				UPDATE 
					`requisitions` 
				SET 
					`status`='".Constant::APPROVED_BY_COMPTROLLER."',
					`datetime_approveddeclined_by_comptroller` = '".date_create()->format('Y-m-d H:i:s')."',
					`comptroller_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requisition_id']."
			";
		} elseif ($data['approver_type'] == Constant::USER_DEPARTMENT_HEAD) {
			$updateStatusQuery = "
				UPDATE 
					`requisitions` 
				SET 
					`status`='".Constant::NOTED_BY_DEPARTMENT_HEAD."',
					`datetime_approveddeclined_by_department_head` = '".date_create()->format('Y-m-d H:i:s')."',
					`department_head_id`=".$data['approved_by']."
				WHERE 
					`id`=".$data['requisition_id']."
			";
		}

		return $this->connection->query($updateStatusQuery);
	}


}