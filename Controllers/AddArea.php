<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Services/AreaService.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $areaServiceObj = new AreaService();

      $result = $areaServiceObj->save([
                  'name'    => $_POST['name']
                ]);

      if ($result) {
        $_SESSION['record_successful_added'] = true;      
      } else {
        $_SESSION['something_wrong'] = true;
      }

      header('location: '.Link::createUrl('Pages/Areas/list.php'));
  }
?>