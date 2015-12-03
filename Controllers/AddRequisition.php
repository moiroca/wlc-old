<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if (isset($_POST['submit'])) {

      $requisitionServiceObj = new RequisitionService();
      $items = [];

      $result = $requisitionServiceObj->save([
                  'type' 	=> $_POST['type'],
                  'purpose'  => $_POST['purpose'],
                  'area_id'   => (int)$_POST['area_id'],
                  'items'    	=> (isset($_POST['items']) && 0 != sizeof($_POST['items']) && is_array($_POST['items'])) ? $_POST['items'] : null
                ]);

      if ($result) {
         $userObj = new User();
         $users = $userObj->getAll(['id'], ['type' => Constant::USER_GSD_OFFICER]);

         $sender_id = Login::getUserLoggedInId();
         $notificationService = new NotificationService();

         if ($_POST['type'] == Constant::REQUISITION_ITEM) {
            $msg = Constant::NOTIFICATION_NEW_ITEM_REQUISITION;
         } else {
            $msg = Constant::NOTIFICATION_NEW_JOB_REQUISITION; 
         }
         
         while ($user = $users->fetch_assoc()) {
            $notificationService->saveNotificationsApprovedByPresident([
              'sender_id'    => $sender_id,
              'recepient_id' => $user['id'],
              'msg'          => $msg
            ]); 
         }

         $_SESSION['record_successful_added'] = true;      
      } else {
         $_SESSION['something_wrong'] = true;
      }

      $url = Link::createUrl('Pages/Requisitions/myrequisitions.php');
      
      header('location: '.$url);
  }
?>