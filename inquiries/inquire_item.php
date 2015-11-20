<?php
session_start();
 include_once("../php/config.php");
  if(!isset($_POST['submit']))
  {
    $result = mysql_query("SELECT * FROM Items where item_status!='Deleted'");

  }
  else 
  {
    $choice = $_POST['choice'];
    $search = $_POST['search'];

    if($_POST['choice'] == 'item_id') {

      $result = mysql_query("SELECT * FROM items where item_id LIKE '%".$_POST['search']."%'");
    }
    else if($_POST['choice'] == 'item_area') {

      $result = mysql_query("SELECT * FROM items where item_area LIKE '%".$_POST['search']."%'");
    }
    else if($_POST['choice'] == 'item_descr') {

      $result = mysql_query("SELECT * FROM items where item_description LIKE '%".$_POST['search']."%'");
    }
    else if($_POST['choice'] == 'item_quantity') {

      $result = mysql_query("SELECT * FROM items where item_quantity LIKE '%".$_POST['search']."%'");
    }
    else if($_POST['choice'] == 'item_status') {

      $result = mysql_query("SELECT * FROM items where item_status LIKE '%".$_POST['search']."%'");
    }
    else {
      echo "<td>Record Not Found</td>";
    }
  }
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
          
          <h1>EQUIPMENT, TOOLS AND MATERIALS</h1>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
               
                  <thead>
                    <form name="actionItem" method="post" action="">
                     Search By:
                      <select name="choice">
                        <option value="item_id">ID</option>
                        <option value="item_area">Area</option>
                        <option value="item_descr">Description</option>
                        <option value="item_quantity">Quantity</option>
                        <option value="item_status">Remarks</option>
                      </select>&nbsp;
                        <input type="text" name="search">
                        <input type="submit" name="submit" value="Submit"><br><br><hr><br>
                      <?php
                                                         
                          
                            echo "
                              <tr id='th'>
                                <th> ID</th>
                                <th> Area</th>
                                <th> Description</th>
                                <th> Quantity</th>
                                <th> Remarks</th>
                                <th> Purpose</th>
                              </tr>
                            "; 
                      ?>
                  </thead>
                  <tbody>
                    <?php 
                    if(mysql_num_rows($result) > 0){ 
                    while($row = mysql_fetch_array($result)){
                      $_SESSION['area_id'] = $row['area_id'];
                      $query = mysql_query("SELECT * from requisition where item_id = '".$row['item_id']."' and area_id='".$row['area_id']."'");
                      if(mysql_num_rows($query) > 0){ 
                        while($row2 = mysql_fetch_array($query)){
                          
                    ?>

                    <tr>
                      <td> <?php echo $row['item_id']; ?></td>
                      <td> <?php echo $row['item_area']; ?></td>
                      <td> <?php echo $row['item_description'] ?></td>
                      <td> <?php echo $row['item_quantity'] .", ". $row2['item_quantity']; ?></td>
                      <td> <?php echo $row['item_status'] .", ". $row2['item_status']; ?></td>
                      <td> <?php echo $row2['item_purpose']; ?></td>

                    </tr>         

                    <?php
                               }
                              }
                            }
                         
                        echo "</table>";  
                      }
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