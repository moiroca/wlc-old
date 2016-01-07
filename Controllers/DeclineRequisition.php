<?php
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

$requisitionId = isset($_POST['requisitionId']) ? $_POST['requisitionId'] : null;

if ($requisitionId) {
	$requsitionRepo = new Requisitions();
	$requisition = $requsitionRepo->getAll(null, ['id' => (int)$requisitionId]);

	$control_identifier = $requisition->fetch_assoc()['control_identifier'];

	$status = '';
	$msg = '';

	switch (Login::getUserLoggedInType()) {

		case Constant::USER_GSD_OFFICER:
			$status = Constant::DECLINED_BY_GSD_OFFICER;
			$msg 	= Constant::NOTIFICATION_DECLINED_BY_GSD_OFFICER;
		break;

		case Constant::USER_PRESIDENT:
			$status = Constant::DECLINED_BY_PRESIDENT;
			$msg 	= Constant::NOTIFICATION_DECLINED_BY_PRESIDENT;
		break;

		case Constant::USER_TREASURER:
			$status = Constant::DECLINED_BY_TREASURER;
			$msg 	= Constant::NOTIFICATION_DECLINED_BY_TREASURER;
		break;

		case Constant::USER_PROPERTY_CUSTODIAN:
			$status = Constant::DECLINED_BY_PROPERTY_CUSTODIAN;
			$msg 	= Constant::NOTIFICATION_DECLINED_BY_PROPERTY_CUSTODIAN;
		break;

		case Constant::USER_COMPTROLLER:
			$status = Constant::DECLINED_BY_COMPTROLLER;
			$msg 	= Constant::NOTIFICATION_DECLINED_BY_PROPERTY_COMPTROLLER;
		break;

		case Constant::USER_DEPARTMENT_HEAD:
			$status = Constant::DECLINED_BY_DEPARTMENT_HEAD;
			$msg 	= Constant::NOTIFICATION_DECLINED_BY_DEPARTMENT_HEAD;
		break;

		default:
			# code...
			break;
	}

	$requisitionService = new RequisitionService();

	if ($status && $requisitionId) {
		$requisitionService->saveRequisitionStatus(Login::getUserLoggedInId(), $requisitionId, $status);
	}

	//--. Notifications .--//

	$notificationService = new NotificationService();

	$notificationService->saveNotification([
	      'sender_id'    => Login::getUserLoggedInId(),
	      'recepient_id' => $requisition->fetch_assoc()['requester_id'],
	      'msg'          => $msg
    ]); 

	echo json_encode([
			'msg' => $status
		]);
}