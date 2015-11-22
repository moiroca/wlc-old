<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

if (Login::isLoggedIn()) { 
  Login::redirectToHome(); 
}

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Inventory System</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width">        
  <link rel="stylesheet" href="css/templatemo_main.css">
</head>
<body>
  <div id="main-wrapper">
    <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1>WLC FACILITIES AND EQUIPMENT - Inventory and Monitoring System</h1></div>
      </div>   
    </div>
  
    <div class="template-page-wrapper">
      
      

      <form class="form-horizontal templatemo-signin-form" role="form" action="Controllers/Login.php" method="post">
        <div class="form-group">
          <div class="col-md-12">
              <?php if (Login::checkIfLoginHasError()) { ?>
                    <div class="alert alert-danger">
                        <p> Username or Password Does Not Match any Record. </p>
                    </div>
              <?php } ?>
          </div>
          <div class="col-md-12">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
              <input type="text" name="username" class="form-control" id="username" placeholder="Username">
            </div>
          </div>              
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" name="login" value="Sign in" class="formbutton">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>