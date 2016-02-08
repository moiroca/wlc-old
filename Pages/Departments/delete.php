<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$departmentRepo   = new Department();

$areaRepo = new Area();

if (isset($_GET['department'])) {
  $department = $departmentRepo->getAll(['*'],['id' => $_GET['department']]);

  if ($department && $department->num_rows != 0) {
    $department = $department->fetch_assoc();
  } else {
    echo json_encode(['error' => 'Department Not Found']);  
    die();
  }
  
} else {
  echo json_encode(['error' => 'Department Id not Defined']);
  die();
}

$departmentRepo->update([
    'deleted_at' => date_create()->format('Y-m-d H:i:s')
  ],[
    'id' => $department['id']
  ]);

header('location: '.Link::createUrl('Pages/Departments/list.php'));