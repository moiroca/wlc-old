<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$userRepo = new User();

if (isset($_GET['user'])) {
  $user = $userRepo->getAll(['id'], ['id' => (int)$_GET['user']]);    

  if ($user && $user->num_rows != 0) {
    $user = $user->fetch_assoc();
  } else {
    echo json_encode(['error' => 'User Not Found']);  
    die();
  }
  
} else {
  echo json_encode(['error' => 'User Id not Defined']);
  die();
}

$userRepo->update([
    'datetime_deleted' => date_create()->format('Y-m-d H:i:s'),
    'status'  => Constant::USER_DELETED
  ],[
    'id' => $user['id']
  ]);

header("location: ".Link::createUrl('Pages/Users/list.php'));