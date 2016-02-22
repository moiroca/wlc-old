<?php
header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

$stockRepo = new Stocks();

$itemControlNumber = isset($_GET['itemControlNumber']) ? $_GET['itemControlNumber'] : '';

$itemIds = (isset($_GET['itemIds']) && !empty($_GET['itemIds'])) ? explode('&', urldecode($_GET['itemIds'])) : '';

$stockResult = $stockRepo->searchItemForJobRequisition($itemControlNumber);

// $stockResult = $stockRepo->getStockByStockName(true, $itemControlNumber, $itemIds);
  
if ($stockResult) {
	$result = $stockResult->fetch_assoc();
}

$area = $stockRepo->getStockCurrentLocation((int)$result['stock_id'])->fetch_assoc();
$result['area_name'] = $area['area_name'];

$result['isEmpty'] = ($stockResult->num_rows == 0);
$result['statuses'] = StockUtility::jobRequisitionStatusType();

echo json_encode($result);

?> 