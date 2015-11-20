<?php
session_start();
  include_once("../php/config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
  <link rel="stylesheet" href="../css/templatemo_main.css">
  <script language="javascript" src="../javascript/confirm.js" type="text/javascript"></script>
</head>

<body>
  <?php include("../includes/header2.php");?>

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li class="active">Create Account</li>
            <li><a href="account_add.php">Manage Users</a></li>
          </ol>
          <h1>Manage Users</h1>

          <div class="row">
            <div class="col-md-12">
              
              <div class="table-responsive">
                <h4 class="margin-bottom-15">Create Account</h4>
                
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Create Account</h4>
                  </div>
                  <div class="panel-body">
                    <?php if($_POST['submit']){                            
                            $conr = mysql_real_escape_string($_POST['ctrl']);
                            $lname = mysql_real_escape_string($_POST['lname']);
                            $fname = mysql_real_escape_string($_POST['fname']);
                            $mi = mysql_real_escape_string($_POST['mi']);
                            $uname = mysql_real_escape_string($_POST['uname']);
                            $pword = mysql_real_escape_string($_POST['pword']);
                            $pword2 = mysql_real_escape_string($_POST['pword2']);
                            $userst = mysql_real_escape_string($_POST['userstat']);
                            $userl = mysql_real_escape_string($_POST['userlvl']);

                            $que = "Select user_id, user_email from User where user_email='".$uname."'";
                            $res = mysql_query($que) or die("YEHET");
                            if(mysql_num_rows($res)){
                              echo"
                              <script>
                              alert('Username already used!');
                              </script>
                              <meta http-equiv='refresh' content='0;url=account_add.php'>
                              ";
                              }
                            else if($pword2!=$pword){
                              echo"
                              <script>
                              alert('password not match');
                              </script>
                              <meta http-equiv='refresh' content='0;url= account_add.php'>
                              ";
                              }
                            
                            else if((int)$conr){
                              $query = "INSERT INTO User(user_id,user_lastname,user_firstname,user_middle,user_email,user_pass,user_status,user_type) 
                                    VALUES ('".$conr."','".$lname."','".$fname."','".$mi."','".$uname."','".$pword."','".$userst."','".$userl."')";
                            $result = mysql_query($query) or die ("Error in query:" .mysql_error());
                            echo"
                              <script>
                              alert('Record Successfully Added!');
                              </script>
                              <meta http-equiv='refresh' content='0;url= account_view.php'>
                              ";
                            
                            }
                            else{
                              echo"<script>
                                alert('Wrong input! Please enter a number for User ID.');
                                </script>
                                <meta http-equiv='refresh' content='0;url= account_add.php'>";
                              }
                          }

                          ?>

                  </div>
                </div>                
              </div>
   
              </div>
              
              <ul class="pagination pull-right">
                <li class="disabled"><a href="#">&laquo;</a></li>
                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">2 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">3 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">4 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">5 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">&raquo;</a></li>
              </ul>  
            </div>
          </div>
        </div>
      </div>


      <footer class="templatemo-footer">
        <div class="templatemo-copyright">
          <p>Copyright &copy; 2084 Your Company Name <!-- Credit: www.templatemo.com --></p>
        </div>
      </footer>
    </div>
</div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>