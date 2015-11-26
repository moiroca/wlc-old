<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Assets.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Services/RequisitionService.php';

Login::sessionStart();

?>

<?php 

  if (isset($_POST['submit'])) {

      $requisitionServiceObj = new RequisitionService();
      $items = [];

      $result = $requisitionServiceObj->save([
                  'type' 	=> $_POST['type'],
                  'purpose'  => $_POST['purpose'],
                  'items'    	=> (isset($_POST['items']) && 0 != sizeof($_POST['items']) && is_array($_POST['items'])) ? $_POST['items'] : null
                ]);

      if ($result) {
         $_SESSION['record_successful_added'] = true;      
      } else {
         $_SESSION['something_wrong'] = true;
      }

      $url = '';
      
      if (isset($_POST['type']) && $_POST['type'] == Constant::REQUISITION_JOB) {
      	$url = Link::createUrl('Pages/Requisitions/Jobs/listing.php');
      } else {
      	$url = Link::createUrl('Pages/Requisitions/Items/listing.php');
      }
      header('location: '.$url);
  }
?>