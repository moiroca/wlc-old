<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $errors = [];
      $userRepo    = new User();

      $isRetainPassword = (isset($_POST['retainPassword'])) ? true : false;

      /* Validations */
      if (!isset($_POST['first_name'])) { $errors['first_name'] = 'First Name is Required'; }
      if (!isset($_POST['last_name'])) { $errors['last_name'] = 'Last Name is Required'; }
      if (!isset($_POST['middle_name'])) { $errors['middle_name'] = 'Middle Name is Required'; }
      if (!isset($_POST['user_type'])) { $errors['user_type'] = 'User Type is Required'; }
      if (!isset($_POST['department_id'])) { $errors['department_id'] = 'Department is Required'; }
      if (!isset($_POST['username'])) { $errors['username'] = 'Username is Required'; 
      } else {

        if (isset($_POST['user_id']) && !$isRetainPassword) {

          //--. Check if Username Already Exist .--//
          $checkedUser = $userRepo->findNotUser(
              (int)$_POST['user_id'],
              $_POST['username']
            );

          if ($checkedUser && $checkedUser->num_rows != 0) {
              $errors['username'] = 'Username already Exist';
          }
        } else {

          if (!isset($_POST['user_id'])) {
            //--. Check if Username Already Exist .--//
            $checkedUser = $userRepo->getAll(['count(*) as user_count'], ['email' => $_POST['username']]);  
            $checkedUser = $checkedUser->fetch_assoc();

            if ($checkedUser && 0 != $checkedUser['user_count']) {
              $errors['username'] = 'Username already Exist';
            }
          }
        }
      }

      if (!$isRetainPassword) {
        if (!isset($_POST['password'])) { $errors['password'] = 'Password is Required'; }
        if (!isset($_POST['cpassword'])) { $errors['cpassword'] = 'Confirm Password is Required';}
        if (isset($_POST['password']) && isset($_POST['cpassword'])) {
          if ($_POST['password'] != $_POST['cpassword']) {
              $errors['matching'] = 'Password And Confirm Password does not match!';
          }
        }
      }

      // End Of Validation

      if (!$errors) { 

        $userService = new UserService();
        $result      = false;

        // if (isset($_POST['user_id'])) {
          
        // } else {

          //--. Save New Department Head .--//
          if ($_POST['user_type'] == Constant::USER_DEPARTMENT_HEAD) {

              //--. Save New User .--//
              if (isset($_POST['user_id'])) {
                $data = [
                    'lastname' => $_POST['last_name'],
                    'firstname' => $_POST['first_name'],
                    'middlename' => $_POST['middle_name'],
                    'type'  => $_POST['user_type'],
                    'datetime_updated' => date_create()->format('Y-m-d H:i:s')
                ];

                if (!$isRetainPassword) {
                  $data['email'] = $_POST['username'];
                  $data['password'] = $_POST['password'];
                }

                $userId = $userRepo->update($data,[
                      'id' => $_POST['user_id']
                  ]);

                $userId = (int)$_POST['user_id'];

              } else {
                $userId = $userService->save($_POST);
              }

              $departmentRepo = new Department();
              $departmentService = new DepartmentService();

              $departmentHead = $departmentRepo->getDepartmentHeadByDepartmentId((int)$_POST['department_id']);
              $departmentHead = $departmentHead->fetch_assoc();

              if ($departmentHead && $departmentHead['user_id'] != $userId) {

                  //--. Update User .--//
                  $updateUserType = $userRepo->update(
                      [ 
                        'type' => Constant::USER_EMPLOYEE 
                      ],
                      [ 
                        'id' => (int)$departmentHead['user_id'] 
                      ]);
                  
                  $departmentService->updateDepartmentHead([
                      'user_id' => $departmentHead['user_id'],
                      'department_id' => (int)$_POST['department_id']
                    ]);
              }

              if (!isset($departmentHead['user_id']) || 
                  (isset($departmentHead['user_id']) && $departmentHead['user_id'] != $userId)) {
                
                $departmentService->saveDepartmentHead([
                  'user_id' => $userId,
                  'department_id' => (int)$_POST['department_id']
                ]);
              }

              $result = true;
          } 

          //--. Save New Treasurer .--//
          if ($_POST['user_type'] == Constant::USER_TREASURER) {
            
            $currentTreasurer = $userRepo->getAll(['id as treasuer_id'], ['type' => Constant::USER_TREASURER]);
            $currentTreasurer = $currentTreasurer->fetch_assoc();

            if ($currentTreasurer && $currentTreasurer['treasuer_id'] != $_POST['user_id']) {

              //--. Update User .--//
              $updateUserType = $userRepo->update(
                  [ 'type' => Constant::USER_EMPLOYEE ],
                  [ 'id'   => $currentTreasurer['treasuer_id'] ]);
            }

            if (isset($_POST['user_id'])) {
              $data = [
                'lastname' => $_POST['last_name'],
                'firstname' => $_POST['first_name'],
                'middlename' => $_POST['middle_name'],
                'type'  => $_POST['user_type'],
                'datetime_updated' => date_create()->format('Y-m-d H:i:s')
              ];

              if (!$isRetainPassword) {
                $data['email'] = $_POST['username'];
                $data['password'] = $_POST['password'];
              }

              $userId = $userRepo->update($data,[
                  'id' => $_POST['user_id']
              ]);       
            } else {
              //--. Save New User .--//
              $userId = $userService->save($_POST);
            }
          }

          //--. Save New Comptroller .--//
          if ($_POST['user_type'] == Constant::USER_COMPTROLLER) {

            $currentComptroller = $userRepo->getAll(['id as comptroller_id'], ['type' => Constant::USER_COMPTROLLER]);
            $currentComptroller = $currentComptroller->fetch_assoc();

            if ($currentComptroller && $currentComptroller['comptroller_id'] != $_POST['user_id']) {

              //--. Update User .--//
              $updateUserType = $userRepo->update(
                  [ 'type' => Constant::USER_EMPLOYEE ],
                  [ 'id'   => $currentComptroller['comptroller_id'] ]);
            }

            if (isset($_POST['user_id'])) {
              $data = [
                'lastname' => $_POST['last_name'],
                'firstname' => $_POST['first_name'],
                'middlename' => $_POST['middle_name'],
                'type'  => $_POST['user_type'],
                'datetime_updated' => date_create()->format('Y-m-d H:i:s')
              ];

              if (!$isRetainPassword) {
                $data['email'] = $_POST['username'];
                $data['password'] = $_POST['password'];
              }

              $userId = $userRepo->update($data,[
                  'id' => $_POST['user_id']
              ]);       
            } else {
              //--. Save New User .--//
              $userId = $userService->save($_POST);
            }
          }

          //--. Save New President .--//
          if ($_POST['user_type'] == Constant::USER_PRESIDENT) {

            $currentPresident = $userRepo->getAll(['id as president_id'], ['type' => Constant::USER_PRESIDENT]);
            $currentPresident = $currentPresident->fetch_assoc();

            if ($currentPresident && $currentPresident['president_id'] != $_POST['user_id']) {

              //--. Update User .--//
              $updateUserType = $userRepo->update(
                  [ 'type' => Constant::USER_EMPLOYEE ],
                  [ 'id'   => $currentPresident['president_id'] ]);
            }

            if (isset($_POST['user_id'])) {
              $data = [
                'lastname' => $_POST['last_name'],
                'firstname' => $_POST['first_name'],
                'middlename' => $_POST['middle_name'],
                'type'  => $_POST['user_type'],
                'datetime_updated' => date_create()->format('Y-m-d H:i:s')
              ];

              if (!$isRetainPassword) {
                $data['email'] = $_POST['username'];
                $data['password'] = $_POST['password'];
              }

              $userId = $userRepo->update($data,[
                  'id' => $_POST['user_id']
              ]);       
            } else {
              //--. Save New User .--//
              $userId = $userService->save($_POST);
            }
          }

          //--. Save New GSD Officer .--//
          if ($_POST['user_type'] == Constant::USER_GSD_OFFICER) {

            $currentGSDOfficer = $userRepo->getAll(['id as gsd_officer_id'], ['type' => Constant::USER_GSD_OFFICER]);
            $currentGSDOfficer = ($currentGSDOfficer) ? $currentGSDOfficer->fetch_assoc() : $currentGSDOfficer;

            if ($currentGSDOfficer && $currentGSDOfficer['gsd_officer_id'] != $_POST['user_id']) {

              //--. Update User .--//
              $updateUserType = $userRepo->update(
                  [ 'type' => Constant::USER_EMPLOYEE ],
                  [ 'id'   => $currentGSDOfficer['gsd_officer_id'] ]);
            }

            if (isset($_POST['user_id'])) {
              $data = [
                'lastname' => $_POST['last_name'],
                'firstname' => $_POST['first_name'],
                'middlename' => $_POST['middle_name'],
                'type'  => $_POST['user_type'],
                'datetime_updated' => date_create()->format('Y-m-d H:i:s')
              ];

              if (!$isRetainPassword) {
                $data['email'] = $_POST['username'];
                $data['password'] = $_POST['password'];
              }

              $userId = $userRepo->update($data,[
                  'id' => $_POST['user_id']
              ]);       
            } else {
              //--. Save New User .--//
              $userId = $userService->save($_POST);
            }
          }

          //--. Save New GSD Officer .--//
          if ($_POST['user_type'] == Constant::USER_PROPERTY_CUSTODIAN) {

            $currentPropertyCustodian = $userRepo->getAll(['id as property_custodian_id'], ['type' => Constant::USER_PROPERTY_CUSTODIAN]);
            $currentPropertyCustodian = ($currentPropertyCustodian) ? $currentPropertyCustodian->fetch_assoc() : $currentPropertyCustodian;

            if ($currentPropertyCustodian && $currentPropertyCustodian['property_custodian_id'] != $_POST['user_id']) {

              //--. Update User .--//
              $updateUserType = $userRepo->update(
                  [ 'type' => Constant::USER_EMPLOYEE ],
                  [ 'id'   => $currentPropertyCustodian['property_custodian_id'] ]);
            }

            if (isset($_POST['user_id'])) {
              $data = [
                'lastname' => $_POST['last_name'],
                'firstname' => $_POST['first_name'],
                'middlename' => $_POST['middle_name'],
                'type'  => $_POST['user_type'],
                'datetime_updated' => date_create()->format('Y-m-d H:i:s')
              ];

              if (!$isRetainPassword) {
                $data['email'] = $_POST['username'];
                $data['password'] = $_POST['password'];
              }

              $userId = $userRepo->update($data,[
                  'id' => $_POST['user_id']
              ]);       
            } else {
              //--. Save New User .--//
              $userId = $userService->save($_POST);
            }
          }

          //--. Save New Employee .--//
          if ($_POST['user_type'] == Constant::USER_EMPLOYEE) {

            if (isset($_POST['user_id'])) {
              $data = [
                'lastname' => $_POST['last_name'],
                'firstname' => $_POST['first_name'],
                'middlename' => $_POST['middle_name'],
                'type'  => $_POST['user_type'],
                'datetime_updated' => date_create()->format('Y-m-d H:i:s')
              ];

              if (!$isRetainPassword) {
                $data['email'] = $_POST['username'];
                $data['password'] = $_POST['password'];
              }

              $userId = $userRepo->update($data,[
                  'id' => $_POST['user_id']
              ]);       
            } else {
              //--. Save New User .--//
              $userId = $userService->save($_POST);
            }
          }

          if ($userId) {
            $_SESSION['record_successful_added'] = true;      
          } else {
            $_SESSION['something_wrong'] = true;
          }

          header("location: ".Link::createUrl('Pages/Users/list.php'));
        // }
      } else {
        
        $_SESSION['errors'] = $errors;
        if (isset($_POST['user_id'])) {
          header("location: ".Link::createUrl('Pages/Users/update.php?user='.$_POST['user_id']));
        } else {
          header("location: ".Link::createUrl('Pages/Users/add.php'));
        }
      }

  }
?>