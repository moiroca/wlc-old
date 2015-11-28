<?php
header('Content-Type: application/json');

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

$stockRepo = new Stocks();

$itemControlNumber = isset($_GET['itemControlNumber']) ? $_GET['itemControlNumber'] : '';
$stockResult = $stockRepo->getByControlNumber($itemControlNumber);

echo json_encode($stockResult->fetch_assoc());

?>