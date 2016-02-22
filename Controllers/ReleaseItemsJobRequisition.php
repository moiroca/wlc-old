<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

$stocksRepo = new Stocks();
$stockRequisitionService = new StockRequisitionService();
$requisitionService = new RequisitionService();
$requisitionRepo = new Requisitions();
$stockService = new StockService();

$stockIds = isset($_POST['itemIds']) ? $_POST['itemIds'] : null;
$statuses = isset($_POST['statuses']) ? $_POST['statuses'] : null;
$requisitionId = isset($_POST['requisitionId']) ? (int)$_POST['requisitionId'] : null;
$status   = Constant::RELEASED_BY_GSD_OFFICER;

$requisition = $requisitionRepo->getAll(['requester_id', 'area_id'], ['id' => $requisitionId]);
$requisition = $requisition->fetch_assoc();

// Update Requisition Status
$requisitionService->updateRequisitionStatus($requisitionId);

// Save Requisition Status
$requisitionService->saveRequisitionStatus(Login::getUserLoggedInId(), $requisitionId, $status);

foreach ($stockIds as $key => $stockId) {

	$stockId = (int)$stockId;
	
	$item = $requisitionRepo->getAllRequisitionItemsByItemIdAndRequisitionId($stockId, $requisitionId)->fetch_assoc();

	if (isset($item['status'])) {
		if ($item['status'] == Constant::STOCK_FOR_REPLACEMENT) {
			
			if (isset($_POST['itemForReplaceIds'][$stockId])) {
				
				$replacementItemId = (int)$_POST['itemForReplaceIds'][$stockId];

				// Update Item Status
				$stockService->updateStockStatus($stockId);

				// Save Item Replaced
				$stockService->saveStockStatus($stockId, Constant::STOCK_OBSOLETE, Login::getUserLoggedInId());
				
				// Updated Item Status in Requisition 
				$requisitionService->updateItemRequisitionStatus($stockId, $requisitionId, Constant::STOCK_REPLACED);	

				// Save Replacement Item 
				$stockService->saveReplacementItem((int)$stockId, (int)$replacementItemId);

				// Update Item Location
				$stockService->updateStockLocation($replacementItemId, $requisition['area_id']);
				
				// Save New Item Location
				$stockService->saveStockLocation($replacementItemId, $requisition['area_id'], Login::getUserLoggedInId());
			}
			
		} else {
			
			if (isset($_POST['action'][$stockId])) {

				// Updated Item Status in Requisition 
				$requisitionService->updateItemRequisitionStatus($stockId, $requisitionId, Constant::STOCK_REPAIRED);	
			
				// Update Item Location
				$stockService->updateStockLocation($stockId, $requisition['area_id']);
				
				// Save New Item Location
				$stockService->saveStockLocation($stockId, $requisition['area_id'], Login::getUserLoggedInId());
			}
		}	
	}
}	

$notificationService = new NotificationService();

$notificationService->saveNotification([
  'sender_id'    => Login::getUserLoggedInId(),
  'recepient_id' => $requisition['requester_id'],
  'msg'          => Constant::NOTIFICATION_VERIFIED_BY_GSD_OFFICER
]);

header('Location: '.Link::createUrl('Pages/Requisitions/Jobs/listing.php'));
