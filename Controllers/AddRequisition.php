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

      $requisition_id = $requisitionServiceObj->save([
                  'type' 	=> $requisitionType,
                  'purpose'  => $requisitionPurpose,
                  'area_id'   => $areaId,
                  'items'    	=> (isset($_POST['items']) && 0 != sizeof($_POST['items']) && is_array($_POST['items'])) ? $_POST['items'] : null
                ]);

      $stockService = new StockService();
      $stockIds = [];

      foreach ($_POST['names'] as $index => $name) { 
        $ids = $stockService->save([
                      'name' => $_POST['names'][$index],
                      'type' => $itemType,
                      'price' => $_POST['amounts'][$index],
                      'area_id' => $areaId,
                      'quantity' => $_POST['quantities'][$index],
                      'status' => Constant::STOCK_GOOD,
                      'isRequest' => true,
                      'unit'  => $_POST['units'][$index]
                    ], true, $stockIds);

        $stockIds = array_merge($stockIds, $ids);
      }

      $stockRequisitionService = new StockRequisitionService();

      $result = $stockRequisitionService->saveStockRequisition([
                  'items' => $stockIds,
                  'requisition_id' => $requisition_id
                ]);

      if ($requisition_id) {
         // $userObj = new User();
         // $users = $userObj->getAll(['id'], ['type' => Constant::USER_GSD_OFFICER]);

         // $sender_id = Login::getUserLoggedInId();
         // $notificationService = new NotificationService();

         // if ($_POST['requisition_type'] == Constant::REQUISITION_ITEM) {
         //    $msg = Constant::NOTIFICATION_NEW_ITEM_REQUISITION;
         // } else {
         //    $msg = Constant::NOTIFICATION_NEW_JOB_REQUISITION; 
         // }
         
         // while ($user = $users->fetch_assoc()) {
         //    $notificationService->saveNotificationsApprovedByPresident([
         //      'sender_id'    => $sender_id,
         //      'recepient_id' => $user['id'],
         //      'msg'          => $msg
         //    ]); 
         // }

         $_SESSION['record_successful_added'] = true;      
      } else {
         $_SESSION['something_wrong'] = true;
      }

      $url = Link::createUrl('Pages/Requisitions/myrequisitions.php');
      
      header('location: '.$url);
  }

?>