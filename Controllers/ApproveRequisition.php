<?php

header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$isError = false;
$errorMSG = '';

if (isset($_POST['requisition_id']) && isset($_POST['type'])) {

	$requisitionService = new RequisitionService();

	$data = [
			'requisition_id'	=> (int)$_POST['requisition_id'],
			'approved_by'	=> Login::getUserLoggedInId(),
			'approver_type' => Login::getUserLoggedInType(),
			'type' 			=> isset($_POST['type']) ? $_POST['type'] : null,
		];

	$requisitionObj = new Requisitions();
	$requisition = $requisitionObj->getAll(['requester_id'], ['id' => (int)$_POST['requisition_id']]);
	
	$result = $requisitionService->approve($data);

	if ($result) {

		$userObj = new User();
	    $GSDOfficers = $userObj->getAll(['id'], ['type' => Constant::USER_GSD_OFFICER]);

	    $sender_id = Login::getUserLoggedInId();
	    $notificationService = new NotificationService();

	    if (Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER) {
	    	$msg = Constant::NOTIFICATION_APPROVED_BY_GSD_OFFICER;

	    	$presidents = $userObj->getAll(['id'], ['type' => Constant::USER_PRESIDENT]);	    	
	    	
	    	while ($president = $presidents->fetch_assoc()) {
	    		$notificationService->saveNotificationsApprovedByPresident([
		          'sender_id'    => $sender_id,
		          'recepient_id' => $president['id'],
		          'msg'          => Constant::NOTIFICATION_FOR_APPROVAL_BY_PRESIDENT
		        ]);	
	    	}
	    } else {

    		$msg = Constant::NOTIFICATION_APPROVED_BY_PRESIDENT;
	    }

        $notificationService->saveNotificationsApprovedByPresident([
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
		'isError'	=> $isError
	]);