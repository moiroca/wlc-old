<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

header('Content-type: application/json');

Login::sessionStart();

$error = '';
$isError = false;
$data = [];

try {

	$user_id		= Login::getUserLoggedInId();
	$datetime_added = date_create()->format('Y-m-d H:i:s');
	$requisition_id = isset($_POST['requisition_id']) ? $_POST['requisition_id'] : null;
	$comment 		= isset($_POST['comment']) ? $_POST['comment'] : null;

	if (!$comment) { throw new Exception('Comment is Required'); }
	if (!$requisition_id) { throw new Exception('Requisition Id not found'); }

	$requisitionCommentService = new RequisitionCommentService();

	$commentId = $requisitionCommentService->saveComment([
			'user_id' => $user_id,
			'requisition_id' => $requisition_id,
			'datetime_added' => $datetime_added,
			'comment'	=> $comment
		]);

	$msg = 'Comment Saved';
	$data = [
			'user' => Login::getFullName(),
			'datetime' => date_create($datetime_added)->format('Y-m-d')
		];

} catch (Exception $e) {
	$msg = $e->getMessage();
	$isError = true;
}

echo json_encode([
		'isError' => $isError,
		'msg' => $msg,
		'data' => $data
	]);
?>