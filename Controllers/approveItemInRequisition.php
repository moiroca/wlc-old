<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

$stocksRepo = new Stocks();
$stockRequisitionService = new StockRequisitionService();
$requisitionService = new RequisitionService();

$requisitionRepo = new Requisitions();
$requisitionId = (int)$_POST['requisitionId'];
$requisition = $requisitionRepo->getAll(['requester_id'], ['id' => $requisitionId]);

$requisition = $requisition->fetch_assoc();

$formItems = $_POST['items'];
$formItems = array_reverse($formItems);

foreach ($formItems as $key => $item) {

	// Get Items In Requisition By Name
	$items = $requisitionRepo->getRequisitionItems($requisitionId, $item['key']);

	$itemIds = array_map(function($item) {
		return (int)array_pop($item);
	}, $items->fetch_all());

	$itemCount = ($items) ? $items->num_rows : 0;
	$itemCountFromRequisition = (int)$item['countFromRequisition'];
	$itemCountFromStocks = (int)$item['countFromStocks'];

	if ( $itemCountFromRequisition <= $itemCount) {

		for ($i=0; $i < $itemCount && $i < $itemCountFromRequisition; $i++) { 
				
			$dateTime = date_create()->format('Y-m-d H:i:s');
			$stocksRepo->update(['datetime_updated' => $dateTime, 'isRequest' => 'FALSE'], ['id' => $itemIds[$i]]);
			$requisitionService->updateItemRequisitionStatus($itemIds[$i], $requisitionId, Constant::STOCK_APPROVED);
		}

		// Search Item in Name
		$searchItems = $stocksRepo->getAllStockByName($item['key']);

		$searchItemsCount = ($searchItems) ? $searchItems->num_rows : 0;
		$searchedItem = ($searchItems) ? $searchItems->fetch_all() : null;

		$forApprovalItemIds = [];
		for ($i = 0; $i < $itemCount && $i < $itemCountFromStocks; $i++) {
			$id = (int)$searchedItem[$i][0];
			if (!$requisitionRepo->checkItemExist($requisitionId, $id)) {
				$forApprovalItemIds[] = $id;
			}
		}

		foreach ($forApprovalItemIds as $key => $itemId) {
			$stockRequisitionService->saveStockRequisition([
				'item' 			 => $itemId,
				'requisition_id' => $requisitionId,
				'status' 		 => Constant::STOCK_APPROVED
			]);	
			
			$requisitionService->updateItemRequisitionStatus($itemId, $requisitionId, Constant::STOCK_APPROVED);
		}
	}
}

$notificationService = new NotificationService();

$notificationService->saveNotification([
  'sender_id'    => Login::getUserLoggedInId(),
  'recepient_id' => $requisition['requester_id'],
  'msg'          => Constant::NOTIFICATION_ITEM_VERIFIED_BY_PRESIDENT
]); 

// Update Requisition Status
$requisitionService->updateRequisitionStatus($requisitionId);

// Update Requisition Status
$requisitionService->saveRequisitionStatus(
	Login::getUserLoggedInId(),
	$requisitionId,
	Constant::APPROVED_BY_PRESIDENT
);