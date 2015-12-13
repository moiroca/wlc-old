<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

$stocksRepo = new Stocks();



$stockIds = isset($_POST['stockIds']) ? $_POST['stockIds'] : null;

if ($stockIds) {
	$dateTime = date_create()->format('Y-m-d H:i:s');

	foreach ($stockIds as $item) {
		var_dump($item['value']);
		$stocksRepo->update(['datetime_updated' => $dateTime, 'isRequest' => ($item['value'] == 'true') ? 'FALSE' : 'TRUE'], ['id' => (int)$item['id']]);		
	}	
}
