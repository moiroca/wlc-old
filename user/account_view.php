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
  <?php include("../includes/header5.php");?>

<div class="templatemo-content-wrapper">
  <div class="templatemo-content">
    <ol class="breadcrumb">
      <li><a href="account_add.php">Create Account</a></li>
      <li class="active">Manage Users</li>
    </ol>
    <h1>Manage Users</h1>

    <div class="row">
      <div class="col-md-12">

        <div class="table-responsive">
          <h4 class="margin-bottom-15">Users Table</h4>
          <table class="table table-striped table-hover table-bordered">
            <form name="useraccount" method="post" action="">
              <thead>
              <?php
                $result = mysql_query("SELECT * FROM User where user_status!='Deleted'");

                if(mysql_num_rows($result) > 0){ 
                  echo" 
                    <tr>
                      <th> Select</th>
                      <th> ID</th>
                      <th> Name</th>
                      <th> Username</th>
                      <th> Password</th>
                      <th> Status</th>
                      <th> UserType</th>
                      <th> Logins</th>
                    </tr>
                  "; 
              ?>
              </thead>
              <tbody>
                <?php 
                  while($row = mysql_fetch_array($result)){
                ?>    
                  <tr>
                    <td> <input type='checkbox' name ='checkbox[]' value= '<?php echo $row['user_id'] ; ?> '></td>
                    <td> <?php echo $row['user_id']; ?></td>
                    <td> <?php echo $row['user_lastname']; ?>, &nbsp <?php echo $row['user_firstname']; ?>&nbsp <?php echo $row['user_middle']; ?></td>  
                    <td> <?php echo $row['user_email'] ?></td>
                    <td> <?php echo $row['user_pass'] ?></td>
                    <td> <?php echo $row['user_status']; ?></td>
                    <td> <?php echo $row['user_type']; ?></td>
                    <td> <?php echo $row['user_logs']; ?></td>
                  </tr>           
                <?php
                  } 
              echo "</table>";  
                }
                echo"<input type='submit' name='update' value='Update' class='butt' onclick='setUpdateActionUser();'>";
                echo"<input type='submit' name='delete' value='Delete' class='butt' onClick='setDeleteActionUser();'>";
                ?> </tbody>
            </form>
          </table>
        </div>

      <!-- <ul class="pagination pull-right">
      <li class="disabled"><a href="#">&laquo;</a></li>
      <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
      <li><a href="#">2 <span class="sr-only">(current)</span></a></li>
      <li><a href="#">3 <span class="sr-only">(current)</span></a></li>
      <li><a href="#">4 <span class="sr-only">(current)</span></a></li>
      <li><a href="#">5 <span class="sr-only">(current)</span></a></li>
      <li><a href="#">&raquo;</a></li>
      </ul>  -->
      </div>
    </div>
  </div>
</div>

<footer class="templatemo-footer">
  <div class="templatemo-copyright">
    <p>Copyright &copy; Soria & Labra.  Credit: www.templatemo.com</p>
  </div>
</footer>
 
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>

</body>
</html>