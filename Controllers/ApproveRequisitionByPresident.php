<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

if (isset($_POST['type']) && isset($_POST['requisitionId'])) {
	$requisitionService = new RequisitionService();

	$data = [
		'requisition_id' => (int)$_POST['requisitionId'],
		'requesterId' => $_POST['requesterId'],
		'approved_by'		 => Login::getUserLoggedInId(),
		'approver_type'  => Constant::USER_PRESIDENT,
		'approved_datetime' => date_create()->format('Y-m-d H:i:s')
	];

	$requisitionService->approve($data);	
}