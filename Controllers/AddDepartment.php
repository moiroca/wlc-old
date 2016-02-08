<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      if (isset($_POST['department_id'])) {
        $departmentRepo = new Department();

        $department = $departmentRepo->getAll(['*'],['id' => $_POST['department_id']]);
        $department = $department->fetch_assoc();

        $departmentRepo->update([
          'name'    => $_POST['name'],
          'updated_at' => date_create()->format('Y-m-d H:i:s')
        ], [
          'id' => $department['id']
        ]);

        header('location: '.Link::createUrl('Pages/Departments/update.php?department='.$department['id']));
      } else {
        $departmentServiceObj = new DepartmentService();

        $result = $departmentServiceObj->save([
                    'name'    => $_POST['name']
                  ]);

        if ($result) {
          $_SESSION['record_successful_added'] = true;      
        } else {
          $_SESSION['something_wrong'] = true;
        }  

        header('location: '.Link::createUrl('Pages/Departments/list.php'));
      }
      
  }
?>