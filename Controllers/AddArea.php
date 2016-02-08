<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $areaService = new AreaService();

      if (isset($_POST['area_id'])) {
        $areaRepo = new Area();

        $areaRepo->update([
            'name' => $_POST['name'],
            'updated_at' => date_create()->format('Y-m-d H:i:s')
          ],[
            'id' => $_POST['area_id']
          ]);

        $areaService->deleteAreaFromDepartment($_POST['area_id']);
        $areaService->saveAreaInDepartment($_POST['area_id'], $_POST['department_id']);

        header('location: '.Link::createUrl('Pages/Areas/update.php?area='.$_POST['area_id']));
      } else {
        $result = $areaService->save([
                  'name'    => $_POST['name'],
                  'department_id' => $_POST['department_id'],
                  'created_at' => date_create()->format('Y-m-d H:i:s')
                ]);

        if ($result) {
          $_SESSION['record_successful_added'] = true;      
        } else {
          $_SESSION['something_wrong'] = true;
        }

        header('location: '.Link::createUrl('Pages/Areas/list.php'));
      }
  }
?>