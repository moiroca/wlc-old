<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $stockService = new StockService();
      $actorId = Login::getUserLoggedInId();
      $status = $_POST['status'];

      for ($i=1; $i <= $_POST['quantity']; $i++) { 

          // Save Stock
          $stockId = $stockService->saveStock([
                          'control_number' => strtotime('+'.$i.' seconds'),
                          'name'    => $_POST['name'],
                          'price'   => $_POST['price'],
                          'type'    => $_POST['type'],
                          'unit'    => $_POST['unit'],
                          'isRequest' => false
                      ]);

          // Save Stock Location
          $stockService->saveStockLocation($stockId, $_POST['area_id'], $actorId);
          
          // Save Stock Status
          $stockService->saveStockStatus($stockId, $status, $actorId);
      }

      $_SESSION['record_successful_added'] = true;      

      if (isset($_POST['type'])) {
        if ($_POST['type'] == Constant::ITEM_MATERIAL_EQUIPMENT) {
          header('location: '.Link::createUrl('Pages/Stocks/MaterialsEquipments.php'));
        } else if($_POST['type'] == Constant::ITEM_OFFICE_SUPPLY) {
          header('location: '.Link::createUrl('Pages/Stocks/OfficeSupply.php'));
        } 
      }
      
  }
?>