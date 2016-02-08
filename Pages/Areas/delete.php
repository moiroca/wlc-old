<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$departmentObj   = new Department();
$departments = $departmentObj->getAll();

$areaRepo = new Area();

if (isset($_GET['area'])) {
  $area = $areaRepo->getAllAreaWithDeparment($_GET['area']);    

  if ($area && $area->num_rows != 0) {
    $area = $area->fetch_assoc();
  } else {
    echo json_encode(['error' => 'Area Not Found']);  
    die();
  }
  
} else {
  echo json_encode(['error' => 'Area Id not Defined']);
  die();
}

$areaService = new AreaService();
$areaRepo = new Area();

$areaRepo->update([
    'deleted_at' => date_create()->format('Y-m-d H:i:s')
  ],[
    'id' => $area['area_id']
  ]);

header('location: '.Link::createUrl('Pages/Areas/list.php'));