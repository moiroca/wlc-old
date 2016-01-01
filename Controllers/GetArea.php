<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

header('Content-Type: application/json');

$areaRepo = new Area();

$error = '';
$areas = [];

try {

	if (!isset($_GET['departmentId'])) {
		throw new Exception('No Department Id Found');
	}	

	if (!$_GET['departmentId']) {
		throw new Exception('No Department Id Empty');
	}

	$areas = $areaRepo->getAllAreaByDepartmentId((int)$_GET['departmentId'])->fetch_all();

} catch (Exception $e) {
	$error = $e->getMessage();

}

echo json_encode([
		'error' => $error,
		'areas' => $areas
	]);