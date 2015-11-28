<?php

header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$isError = false;
$errorMSG = '';

if (isset($_POST['requistion_id']) && isset($_POST['type'])) {
	$data = [
			'requistion_id'	=> isset($_POST['requistion_id']) ? $_POST['requistion_id'] : null,
			'approved_by'	=> Login::getUserLoggedInId(),
			'type' 			=> isset($_POST['type']) ? $_POST['type'] : null,
		];

	$requisitionService = new RequisitionService();		

	$result = $requisitionService->approve($data);
} else {
	$isError = true;
	$errorMSG = 'Something Went Wrong'
}

echo json_encode([
		'errorMSG' 	=> $errorMSG,
		'isError'	=> $isError
	]);