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
        <li><a href="account_view.php">Manage Users</a></li>
      </ol>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive" >
            <div class="col-md-6 col-sm-6 margin-bottom-30">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">Create Account</h4>
                </div>
                <div class="panel-body">
                  <fieldset>
                    <form action = "user_add.php" method="post">
                        <p><label for="ctrl">User ID:</label>
                        <input name="ctrl" id="ctrl" type="text" placeholder="User ID" required="required"/></p>
                        
                        <p><label for="lname">Lastname:</label>
                        <input name="lname" id="lname" type="text" placeholder="Lastname" required="required"/></p>
                        <p><label for="fname">Firstname:</label>
                        <input name="fname" id="fname" type="text" placeholder="Firstname" required="required"/></p>
                        <p><label for="mi">MI:</label>
                        <input name="mi" id="mi" type="text" placeholder="MI"/></p>
                        
                        <p><label for="uname">Username:</label>
                        <input name="uname" id="uname" type="text" placeholder="username" required="required"/></p>
                        <p><label for="pword">Password:</label>
                        <input name="pword" id="pword" type="password" placeholder="password" required="required"/></p>
                        <p><label for="pword2">Confirm Password:</label>
                        <input name="pword2" id="pword2" type="password" placeholder="password" required="required"/></p>
                        <p><label for="userstat">User Status:</label></p>
                        <p><select name="userstat" value="userstat">
                            <option value="Active">Active</option>
                          </select>
                        </p>
                        <p><label for="userlvl">User Type:</label>
                           <select name='userlvl'>
                            <?php 
                            $quer=mysql_query('Select * from user_type');
                                
                                if(mysql_num_rows($quer)>0)
                                    {
                                        while($user_que =  mysql_fetch_array($quer))
                                        
                                        {
                            ?>
                                            <option value='<? echo $user_que['user_type'] ?>' ><? echo $user_que['user_type'] ?><br /></option>
                            <?php
                                        }
                                    }
                            ?>
                        </select></p>
                        <p><input name="submit" style="margin-left: 150px;" class="formbutton" value="Add" type="submit" /></p>
                    </form>
                  </fieldset>
                </div>
              </div>                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="templatemo-footer">
    <div class="templatemo-copyright">
      <p>Copyright &copy; Soria and Labra. Credits to: <a href="www.templatemo.com">Templatemo-adminpanel/dashboard</a></p>
    </div>
  </footer>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>