<?php
header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

$stockRepo = new Stocks();

$itemControlNumber = isset($_GET['itemControlNumber']) ? $_GET['itemControlNumber'] : '';

$itemIds = (isset($_GET['itemIds']) && !empty($_GET['itemIds'])) ? explode('&', urldecode($_GET['itemIds'])) : '';


$stockResult = $stockRepo->getByControlNumber($itemControlNumber);

$stockResult = $stockRepo->getStockByStockName(true, $itemControlNumber, $itemIds);
  
if ($stockResult) {
	$result = $stockResult->fetch_assoc();
}

$result['isEmpty'] = ($stockResult);
$result['statuses'] = StockUtility::jobRequisitionStatusType();

echo json_encode($result);

?>