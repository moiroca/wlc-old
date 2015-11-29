<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

?>

<?php 

  if ($_POST['submit']) {

      $errors = [];

      /* Validations */
      if (!isset($_POST['first_name'])) { $errors['first_name'] = 'First Name is Required'; }
      if (!isset($_POST['last_name'])) { $errors['last_name'] = 'Last Name is Required'; }
      if (!isset($_POST['middle_name'])) { $errors['middle_name'] = 'Middle Name is Required'; }
      if (!isset($_POST['user_type'])) { $errors['user_type'] = 'User Type is Required'; }
      if (!isset($_POST['department_id'])) { $errors['department_id'] = 'Department is Required'; }
      if (!isset($_POST['username'])) { $errors['username'] = 'Username is Required'; }
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
        $result = $userService->save($_POST);

        if ($result) {
          $_SESSION['record_successful_added'] = true;      
        } else {
          $_SESSION['something_wrong'] = true;
        }

        if (isset($_POST['user_type'])) {

          if ($_POST['user_type'] == Constant::USER_GSD_OFFICER) {
            header('location: '.Link::createUrl('Pages/Users/GeneralServices/listing.php'));
          } else if($_POST['user_type'] == Constant::USER_PRESIDENT) {
            header('location: '.Link::createUrl('Pages/Users/Presidents/listing.php'));
          } else if ($_POST['user_type'] == Constant::USER_DEAN) {
            header('location: '.Link::createUrl('Pages/Users/Deans/listing.php'));
          }
        }
      } else {
         $_SESSION['errors'] = $errors;
         header("location: ".Link::createUrl('Pages/Users/add.php'));
      }
  }
?>
