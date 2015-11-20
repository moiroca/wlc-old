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
  <?php include("../includes/header2.php");
        $area_id = $_GET['area_id'];?>

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <h1>REQUISITION FOR 
          <?php 
          $result = mysql_query("SELECT * FROM area_dept where area_id = '". $area_id."'");                               
          $row = mysql_fetch_array($result);
          echo $row['area_name']; 
          $_SESSION['area_name'] = $row['area_name'];
          $_SESSION['area_id'] = $area_id;
          ?></h1>
          <!--<h1>ADD INVENTORY REPORT</h1>-->

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                  <form name="addInventory" method="post" action="requisition_add_replace.php">
                    <!--Checked by: <input type="text" name="checked_by" placeholder="Complete Name, Post-Nominals" style="width:300px;"required="required"/> 
                    <br><br>Date: <input type="date" name="date_from" style="height:30px;" required="required"/> to <input type="date" name="date_to" style="height:30px;" required="required"/><br><br> 
                    --><h5 style="color:red;">*Only QUANTITY and REMARKS can be EDITED.<br> &nbsp;&nbsp;Please Review before SAVING.</h5>                      <?php
                         
                          
                          $result = mysql_query("SELECT * FROM Items where area_id = '". $area_id."' AND item_status!='Deleted'");                               
                          if(mysql_num_rows($result) > 0){ 
                            echo "
                              <tr id='th'>
                                <th> Control No</th>
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
                    ?>
                    <tr>
                      <td><input type='readonly' name ='item_id[]' value= '<?php echo $row['item_id'] ; ?> ' readonly></td>
                      <td> <input type='readonly' name ='item_area[]' value= '<?php echo $row['item_area'] ; ?> ' readonly/></td>
                      <td> <input type='readonly' name ='item_description[]' value= '<?php echo $row['item_description'] ; ?> ' readonly/></td>
                      <td> <input type='text' name ='item_quantity[]' value= '<?php echo $row['item_quantity'] ; ?> '></td>
                      <td> <select name="item_status[]">
                        <option name="good" value="Good Condition">Good Condition</option>
                        <option name="replace" value="For Replace">For Replace</option>
                      </select></td>
                    </tr>           
                    <?php
                        }
                        echo "</table>";  
                      }
                    echo"<input type='submit' name='submit' value='Save'>";
                    ?>    
                    </tbody>
                  </form>
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