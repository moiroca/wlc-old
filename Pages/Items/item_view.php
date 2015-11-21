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
            <li><a href="item_add.php">Add Record</a></li>
            <!--<li><a href="../addreport/inventory_add.php?area_id=<?php echo $_SESSION['area_id']; ?>">Add Inventory Report</a></li>
            --><li class="active">Manage Items</li>
          </ol>
          <h1>EQUIPMENT, TOOLS AND MATERIALS</h1>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                    <form name="actionItem" method="post" action="">
                      <?php
                          $area_id = $_GET['area_id'];
                          $_SESSION['area_id'] = $area_id;
                          $result = mysql_query("SELECT * FROM Items where area_id = '". $area_id."' AND item_status!='Deleted'");                               
                          if(mysql_num_rows($result) > 0){ 
                            echo "
                              <tr id='th'>
                                <th> Select</th>
                                <th> ID</th>
                                <th> Area</th>
                                <th> Description</th>
                                <th> Quantity</th>
                                <th> Remarks</th>
                              </tr>
                            "; 
                      ?>
                  </thead>
                  <tbody>
                    <?php 
                    while($row = mysql_fetch_array($result)){
                      $_SESSION['area_id'] = $row['area_id'];
                    ?>

                    <tr>
                      <td> <input type='checkbox' name ='checkbox[]' value= '<?php echo $row['item_id'] ; ?> '></td>
                      <td> <?php echo $row['item_id']; ?></td>
                      <td> <?php echo $row['item_area']; ?></td>
                      <td> <?php echo $row['item_description'] ?></td>
                      <td> <?php echo $row['item_quantity']; ?></td>
                      <td> <?php echo $row['item_status']; ?></td>
                    </tr>         

                    <?php
                        }
                        echo "</table>";  
                      }
                    echo"<input type='submit' name='update' value='Update' class='butt' onclick='setUpdateActionItem();'>";
                    echo"<input type='submit' name='delete' value='Delete' class='butt' onClick='setDeleteActionItem();'>";
                    ?> 

                  </tbody>
                </table>
                
              </div>
              
              <!--
              <ul class="pagination pull-right">
                <li class="disabled"><a href="#">&laquo;</a></li>
                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">2 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">3 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">4 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">5 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">&raquo;</a></li>
              </ul> --> 
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