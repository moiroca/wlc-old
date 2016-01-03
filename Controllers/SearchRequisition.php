<?php
header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

$stockRepo = new Stocks();

$itemControlNumber = isset($_GET['itemControlNumber']) ? $_GET['itemControlNumber'] : '';
$stockResult = $stockRepo->getByControlNumber($itemControlNumber);

$result = $stockResult->fetch_assoc();

$result['isEmpty'] = (0 != $stockResult->num_rows);

$result['statuses'] = StockUtility::jobRequisitionStatusType();

echo json_encode($result);

?>