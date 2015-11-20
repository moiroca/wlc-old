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
  <script type="text/javascript" src="../javascript/jQuery v1.7.js"></script>

</head>
<body>
  <?php include("../includes/header5.php");?>

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          
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
                             <th> Description</th>
                             <th> Dean / Area In-Charge</th>
                             </tr>"; ?>
                  </thead>
                  <tbody>
                    <?php 
                      while($row = mysql_fetch_array($result)){
                        
                    ?>  <!--<a href="../items/item_view.php?area_id=<?php echo $row['area_id']; ?>">-->  
                      <tr>
                        <td> <a href="../itemPrint2.php?area_id=<?php echo $row['area_id']; ?>"> <?php echo $row['area_name'] ?> </a></td>
                        <td> <?php echo $row['dept_dean'] ?></td>
                      </tr>           
                    <?php
                        }
                        echo "</table>";  
                      }
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