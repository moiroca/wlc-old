<?php
session_start();
  include_once("php/configure.php");
  
  /*if(!isset($_SESSION['login'])){
    header("Location: index.php");
  }*/

  if(isset($_SESSION['login']) && $_SESSION['login'] == "Admin"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else{
    $out = '<a href="../index.php"> Sign out </a>';
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

      <form class="form-horizontal templatemo-signin-form" role="form" action="php/logincheck.php" method="post">
        <div class="form-group">
          <div class="col-md-12">
            <label for="uname" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
              <input type="text" name="uname" class="form-control" id="username" placeholder="Username">
            </div>
          </div>              
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="pword" class="form-control" id="password" placeholder="Password">
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