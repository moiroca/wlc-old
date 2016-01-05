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
							datetime_added,
							control_identifier,
							area_id) 
					VALUES (
						".$this->connection->real_escape_string($requester_id).",
						'".$this->connection->real_escape_string($data['purpose'])."', 
						'".$this->connection->real_escape_string($data['type'])."',
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
		$status = '';
		
		if ($data['approver_type'] == Constant::USER_GSD_OFFICER) {
			$status = Constant::VERIFIED_BY_GSD_OFFICER;
		} elseif ($data['approver_type'] == Constant::USER_PRESIDENT) {
			$status = Constant::APPROVED_BY_PRESIDENT;
		} else if ($data['approver_type'] == Constant::USER_TREASURER) {
			$status = Constant::APPROVED_BY_TREASURER;
		} elseif ($data['approver_type'] == Constant::USER_PROPERTY_CUSTODIAN) {
			$status = Constant::VERIFIED_BY_PROPERTY_CUSTODIAN;
		} elseif ($data['approver_type'] == Constant::USER_COMPTROLLER) {
			$status = Constant::APPROVED_BY_COMPTROLLER;
		} elseif ($data['approver_type'] == Constant::USER_DEPARTMENT_HEAD) {
			$status = Constant::NOTED_BY_DEPARTMENT_HEAD;
		}

		$this->saveRequisitionStatus(
			$data['approved_by'],
			$data['requisition_id'],
			$status
		);
	}

	/**
	 * Insert Requisition Status
	 *
	 * @param Int $userId
	 * @param Int $requisitionId
	 * @param String $status
	 */
	public function saveRequisitionStatus($userId, $requisitionId, $status)
	{
		$sql = "
			INSERT
			INTO
				`requisition_status`(
						`user_id`,
						`requisition_id`,
						`status`,
						`datetime_added`
					)
			VALUES(
					$userId,
					$requisitionId,
					'".$status."',
					'".date_create()->format('Y-m-d H:i:s')."'
				)
		";

		return $this->connection->query($sql);
	}
}