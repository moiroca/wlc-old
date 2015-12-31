<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$result = [];
$error = '';

try {
	
	header('Content-type: application/json');

	$department = new Department();	
	if (!isset($_GET['departmentId'])) { 
		throw new Exception('No Department ID Found');
	}

	$department = $department->getDepartmentHeadByDepartmentId((int)$_GET['departmentId']);
	$department = $department->fetch_assoc();

	if (!$department) {
		throw new Exception('No Department Head Found');
	} else {
		$department = RequesterUtility::getFullName($department);
	}

} catch (Exception $e) {
	$error = $e->getMessage();
	$department = '';
}

echo json_encode([
		'error' => $error,
		'departmentHead' => $department
	]);
?>