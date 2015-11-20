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
            <li><a href="department_add.php">Add Department</a></li>
            <li class="active">Manage Department</li>
          </ol>
          <h1>DEPARTMENT</h1>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                    <form name="actionDepartment" method="post" action="">
                      <?php
                        $result = mysql_query("SELECT * FROM area_dept where area_status = 'Displayed' ");
                        if(mysql_num_rows($result) > 0){
                          echo "<tr id='th'>
                             <th> Select</th>
                             <th> Description</th>
                             <th> Dean / Area In-Charge</th>
                             </tr>"; ?>
                  </thead>
                  <tbody>
                    <?php 
                      while($row = mysql_fetch_array($result)){
                        
                    ?>     
                      <tr>
                        <td> <input type='checkbox' name ='checkbox[]' value= '<?php echo $row['area_id'] ; ?> '></td>
                        <td> <?php echo $row['area_name'] ?></td>
                        <td> <?php echo $row['dept_dean'] ?></td>
                      </tr>           
                    <?php
                        }
                        echo "</table>";  
                      }
                      echo"<input type='submit' name='update' value='Update' class='butt' onclick='setUpdateActionDept();'>";
                      echo"<input type='submit' name='delete' value='Delete' class='butt' onClick='setDeleteActionDept();'>";
                    ?>                
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      <footer class="templatemo-footer">
        <div class="templatemo-copyright">
          <p>Copyright &copy; Soria & Labra.  Credit: www.templatemo.com</p>
        </div>
      </footer>
    </div>
</div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>