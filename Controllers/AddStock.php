<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Assets.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Services/StockService.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $stockServiceObj = new StockService();

      $result = $stockServiceObj->save([
                  'area_id' => $_POST['area_id'],
                  'name'    => $_POST['name'],
                  'quantity'=> $_POST['quantity'],
                  'status'  => $_POST['status'],
                  'type'    => $_POST['type']
                ]);

      if ($result) {
        $_SESSION['record_successful_added'] = true;      
      } else {
        $_SESSION['something_wrong'] = true;
      }

      if (isset($_POST['type'])) {
        if ($_POST['type'] == Constant::ITEM_TOOL) {
          header('location: '.Link::createUrl('Pages/Stocks/Tools/tools.php'));
        } else if($_POST['type'] == Constant::ITEM_EQUIPMENT) {
          header('location: '.Link::createUrl('Pages/Stocks/Equipments/equipments.php'));
        } else {
          header('location: '.Link::createUrl('Pages/Stocks/Materials/materials.php'));
        }
      }
      
  }
?>