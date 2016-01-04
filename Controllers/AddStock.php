<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $stockServiceObj = new StockService();

      $result = $stockServiceObj->save([
                  'name'    => $_POST['name'],
                  'quantity'=> $_POST['quantity'],
                  'area_id' => $_POST['area_id'],
                  'price'   => $_POST['price'],
                  'status'  => $_POST['status'],
                  'type'    => $_POST['type'],
                  'unit'    => $_POST['unit'],
                  'isRequest' => false
                ]);

      if ($result) {
        $_SESSION['record_successful_added'] = true;      
      } else {
        $_SESSION['something_wrong'] = true;
      }

      if (isset($_POST['type'])) {
        if ($_POST['type'] == Constant::ITEM_MATERIAL_EQUIPMENT) {
          header('location: '.Link::createUrl('Pages/Stocks/MaterialsEquipments.php'));
        } else if($_POST['type'] == Constant::ITEM_OFFICE_SUPPLY) {
          header('location: '.Link::createUrl('Pages/Stocks/OfficeSupply.php'));
        } 
      }
      
  }
?>