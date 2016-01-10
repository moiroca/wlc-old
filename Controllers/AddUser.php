<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $errors = [];
      $userRepo    = new User();

      /* Validations */
      if (!isset($_POST['first_name'])) { $errors['first_name'] = 'First Name is Required'; }
      if (!isset($_POST['last_name'])) { $errors['last_name'] = 'Last Name is Required'; }
      if (!isset($_POST['middle_name'])) { $errors['middle_name'] = 'Middle Name is Required'; }
      if (!isset($_POST['user_type'])) { $errors['user_type'] = 'User Type is Required'; }
      if (!isset($_POST['department_id'])) { $errors['department_id'] = 'Department is Required'; }
      if (!isset($_POST['username'])) { $errors['username'] = 'Username is Required'; 
      } else {
        //--. Check if Username Already Exist .--//
        $checkedUser = $userRepo->getAll(['count(*) as user_count'], ['email' => $_POST['username']]);
        $checkedUser = $checkedUser->fetch_assoc();

        if ($checkedUser && 0 != $checkedUser['user_count']) {
          $checkedUser = $checkedUser->fetch_assoc();
          $errors['username'] = 'Username already Exist';
        } 
      }
      if (!isset($_POST['password'])) { $errors['password'] = 'Password is Required'; }
      if (!isset($_POST['cpassword'])) { $errors['cpassword'] = 'Confirm Password is Required';}
      if (isset($_POST['password']) && isset($_POST['cpassword'])) {
        if ($_POST['password'] != $_POST['cpassword']) {
            $errors['matching'] = 'Password And Confirm Password does not match!';
        }
      }

      // End Of Validation

      if (!$errors) { 

        $userService = new UserService();
        $result      = false;

        //--. Save New User .--//
        $userId = $userService->save($_POST);

        //--. Save New Department Head .--//
        if ($_POST['user_type'] == Constant::USER_DEPARTMENT_HEAD) {

            $departmentRepo = new Department();
            $departmentService = new DepartmentService();

            $departmentHead = $departmentRepo->getDepartmentHeadByDepartmentId((int)$_POST['department_id']);
            $departmentHead = $departmentHead->fetch_assoc();

            if ($departmentHead) {

                //--. Update User .--//
                $updateUserType = $userRepo->update(
                    [ 'type' => Constant::USER_EMPLOYEE ],
                    [ 'id' => (int)$departmentHead['user_id'] ]);
                
                $departmentService->updateDepartmentHead([
                    'user_id' => $departmentHead['user_id'],
                    'department_id' => (int)$_POST['department_id']
                  ]);
            }

            $departmentService->saveDepartmentHead([
              'user_id' => $userId,
              'department_id' => (int)$_POST['department_id']
            ]);

            $result = true;
        } 

        //--. Save New Treasurer .--//
        if ($_POST['user_type'] == Constant::USER_TREASURER) {
          $currentTreasurer = $userRepo->getAll(['id as treasuer_id'], ['type' => Constant::USER_TREASURER]);
          $currentTreasurer = $currentTreasurer->fetch_assoc();

          if ($currentTreasurer) {

            //--. Update User .--//
            $updateUserType = $userRepo->update(
                [ 'type' => Constant::USER_EMPLOYEE ],
                [ 'id'   => $currentTreasurer['treasuer_id'] ]);
          }
        }

        //--. Save New Comptroller .--//
        if ($_POST['user_type'] == Constant::USER_COMPTROLLER) {

          $currentComptroller = $userRepo->getAll(['id as comptroller_id'], ['type' => Constant::USER_COMPTROLLER]);
          $currentComptroller = $currentComptroller->fetch_assoc();

          if ($currentComptroller) {

            //--. Update User .--//
            $updateUserType = $userRepo->update(
                [ 'type' => Constant::USER_EMPLOYEE ],
                [ 'id'   => $currentComptroller['comptroller_id'] ]);
          }
        }

        //--. Save New President .--//
        if ($_POST['user_type'] == Constant::USER_PRESIDENT) {

          $currentPresident = $userRepo->getAll(['id as president_id'], ['type' => Constant::USER_PRESIDENT]);
          $currentPresident = $currentPresident->fetch_assoc();

          if ($currentPresident) {

            //--. Update User .--//
            $updateUserType = $userRepo->update(
                [ 'type' => Constant::USER_EMPLOYEE ],
                [ 'id'   => $currentPresident['president_id'] ]);
          }
        }

        //--. Save New GSD Officer .--//
        if ($_POST['user_type'] == Constant::USER_GSD_OFFICER) {

          $currentGSDOfficer = $userRepo->getAll(['id as gsd_officer_id'], ['type' => Constant::USER_GSD_OFFICER]);
          $currentGSDOfficer = ($currentGSDOfficer) ? $currentGSDOfficer->fetch_assoc() : $currentGSDOfficer;

          if ($currentGSDOfficer) {

            //--. Update User .--//
            $updateUserType = $userRepo->update(
                [ 'type' => Constant::USER_EMPLOYEE ],
                [ 'id'   => $currentGSDOfficer['gsd_officer_id'] ]);
          }
        }

        if ($userId) {
          $_SESSION['record_successful_added'] = true;      
        } else {
          $_SESSION['something_wrong'] = true;
        }

        header("location: ".Link::createUrl('Pages/Users/list.php'));
      } else {
        $_SESSION['errors'] = $errors;
        header("location: ".Link::createUrl('Pages/Users/add.php'));
      }

  }
?>