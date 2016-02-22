<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 
  
  if (isset($_POST['submit'])) {

      $requisitionServiceObj = new RequisitionService();
      $items = [];

      $requisitionType    = (isset($_POST['requisition_type']) && !is_null($_POST['requisition_type'])) ? $_POST['requisition_type']  : '';
      $requisitionPurpose = (isset($_POST['purpose']) && !is_null($_POST['purpose'])) ? $_POST['purpose']  : '';
      $areaId             = (isset($_POST['area_id']) && !is_null($_POST['area_id'])) ? (int)$_POST['area_id']  : 0;
      $itemType           = (isset($_POST['type']) && !is_null($_POST['type'])) ? $_POST['type']  : '';

      // Save Requisition and Retrieve Requisition ID
      $requisition_id = $requisitionServiceObj->save([
                    'type'  => $requisitionType,
                    'purpose'  => $requisitionPurpose,
                    'area_id'   => $areaId
                  ]);

      $requisitionServiceObj->saveRequisitionStatus(Login::getUserLoggedInId(), $requisition_id, Constant::REQUISITION_PENDING);

      $stockRequisitionService = new StockRequisitionService();

      if ($requisitionType == Constant::REQUISITION_JOB) {

        foreach ($_POST['items'] as $index => $item) {
            $stockRequisitionService->saveStockRequisition([
              'item'            => $item,
              'requisition_id'  => $requisition_id,
              'status'          => $_POST['statuses'][$index]
            ], true);
        }

      } else {

        $stockService = new StockService();
        $stockIds = [];
        $actorId = Login::getUserLoggedInId();

        foreach ($_POST['names'] as $index => $name) {
          for ($i = 1; $i <= $_POST['quantities'][$index] ; $i++) { 
              $stockId = $stockService->saveStock([
                            'control_number' => strtotime('+'.$i.' seconds'),
                            'name'    => $_POST['names'][$index],
                            'price'   => $_POST['amounts'][$index],
                            'type'    => $itemType,
                            'unit'    => $_POST['units'][$index],
                            'isRequest' => true
                        ]);

              // Save Stock Requisition 
              $stockRequisitionService->saveStockRequisition([
                          'item'            => $stockId,
                          'requisition_id'  => $requisition_id,
                          'status'          => Constant::STOCK_FOR_APPROVAL
                        ]);

              // Save Stock Location
              $stockService->saveStockLocation($stockId, $areaId, $actorId);
              
              // Save Stock Status
              $stockService->saveStockStatus($stockId, Constant::STOCK_NEW_CONDITION, $actorId);
          }
        }
      }

      if ($requisition_id) {

          $userObj = new User();
          $users = $userObj->getAll(['id'], ['type' => Constant::USER_GSD_OFFICER]);

          $notificationService = new NotificationService();

          $msg = ($_POST['requisition_type'] == Constant::REQUISITION_ITEM) ? Constant::NOTIFICATION_NEW_ITEM_REQUISITION : Constant::NOTIFICATION_NEW_JOB_REQUISITION; 

          $userObj = new User();

          //--. .--//
          if ($itemType == Constant::ITEM_MATERIAL_EQUIPMENT || $_POST['requisition_type'] == Constant::REQUISITION_JOB) {
            $users = $userObj->getAll(['id'], ['type' => Constant::USER_GSD_OFFICER]);
          } else {
            $users = $userObj->getAll(['id'], ['type' => Constant::USER_PROPERTY_CUSTODIAN]);
          }

          $user = ($users && $users->num_rows != 0) ? $users->fetch_assoc() : '';

          if ($user) {
            $notificationService->saveNotification([
              'sender_id'    => Login::getUserLoggedInId(),
              'recepient_id' => $user['id'],
              'msg'          => $msg
            ]);  
          }

         $_SESSION['record_successful_added'] = true;      
      } else {
         $_SESSION['something_wrong'] = true;
      }

      header('location: '.Link::createUrl('Pages/Requisitions/myrequisitions.php'));
  }

?>