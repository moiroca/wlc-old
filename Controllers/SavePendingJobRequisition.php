<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

$stocksRepo = new Stocks();
$stockRequisitionService = new StockRequisitionService();
$requisitionService = new RequisitionService();
$requisitionRepo = new Requisitions();

$stockIds = isset($_POST['ids']) ? $_POST['ids'] : null;
$statuses = isset($_POST['statuses']) ? $_POST['statuses'] : null;
$requisitionId = isset($_POST['requisitionId']) ? (int)$_POST['requisitionId'] : null;
$status   = isset($_POST['status']) ? $_POST['status'] : null;

$requisition = $requisitionRepo->getAll(['requester_id'], ['id' => $requisitionId]);
$requisition = $requisition->fetch_assoc();

// Update Requisition Status
$requisitionService->updateRequisitionStatus($requisitionId);

// Save Requisition Status
$requisitionService->saveRequisitionStatus(Login::getUserLoggedInId(), $requisitionId, $status);

foreach ($stockIds as $key => $stockId) {
	$requisitionService->updateItemRequisitionStatus($stockId, $requisitionId, $statuses[$key]);
}

$notificationService = new NotificationService();

$notificationService->saveNotification([
	          'sender_id'    => Login::getUserLoggedInId(),
	          'recepient_id' => $requisition['requester_id'],
	          'msg'          => ($status == Constant::VERIFIED_BY_GSD_OFFICER) ? Constant::NOTIFICATION_VERIFIED_BY_GSD_OFFICER : Constant::NOTIFICATION_DECLINED_BY_GSD_OFFICER
	        ]);

if ($status == Constant::VERIFIED_BY_GSD_OFFICER) {
	// Notify President
	$notificationService->notifyPresident([
		          'sender_id'    => Login::getUserLoggedInId(),
		          'msg'          => Constant::NOTIFICATION_FOR_APPROVAL_BY_PRESIDENT
		        ]);
}

header('Location: '.Link::createUrl('Pages/Requisitions/Jobs/listing.php'));
