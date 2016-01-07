<?php

header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$isError = false;
$errorMSG = '';
$msg = '';

if (isset($_POST['requisition_id']) && isset($_POST['type'])) {

	$requisitionService = new RequisitionService();

	$requisitionObj = new Requisitions();
	$requisitionId = (int)$_POST['requisition_id'];
	$requisition = $requisitionObj->getAll(['requester_id'], ['id' => $requisitionId]);

	$data = [
			'requisition_id'	=> (int)$_POST['requisition_id'],
			'approved_by'	=> Login::getUserLoggedInId(),
			'approver_type' => Login::getUserLoggedInType(),
			'type' 			=> isset($_POST['type']) ? $_POST['type'] : null,
		];

	$requisitionService->approve($data);	

	if ($requisitionId) {

	    $sender_id = Login::getUserLoggedInId();
	    $notificationService = new NotificationService();

	    if ($data['approver_type'] == Constant::USER_GSD_OFFICER) {
	    	$msg = Constant::NOTIFICATION_VERIFIED_BY_GSD_OFFICER;
		} elseif ($data['approver_type'] == Constant::USER_PRESIDENT) {
			$msg = Constant::NOTIFICATION_APPROVED_BY_PRESIDENT;
		} else if ($data['approver_type'] == Constant::USER_TREASURER) {
			$msg = Constant::NOTIFICATION_APPROVED_BY_TREASURER;
		} elseif ($data['approver_type'] == Constant::USER_PROPERTY_CUSTODIAN) {
			$msg = Constant::NOTIFICATION_VERIFIED_BY_PROPERTY_CUSTODIAN;
		} elseif ($data['approver_type'] == Constant::USER_COMPTROLLER) {
			$msg = Constant::NOTIFICATION_APPROVED_BY_COMPTROLLER;
		} elseif ($data['approver_type'] == Constant::USER_DEPARTMENT_HEAD) { 
			$msg = Constant::NOTIFICATION_NOTED_BY_DEPARTMENT_HEAD;
		}

        $notificationService->saveNotification([
          'sender_id'    => $sender_id,
          'recepient_id' => $requisition->fetch_assoc()['requester_id'],
          'msg'          => $msg
        ]); 
	}
} else {
	$isError = true;
	$errorMSG = 'Something Went Wrong';
}

echo json_encode([
		'errorMSG' 	=> $errorMSG,
		'isError'	=> $isError,
		'successMSG' => $requisitionObj->getCurrentRequisitionStatus($requisitionId),
	]);