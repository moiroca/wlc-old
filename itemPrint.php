<?php 
session_start();
  include_once("php/config.php");

  $area_id = $_GET['area_id'];
  $result = mysql_query("SELECT * FROM items where area_id='".$area_id."'");
  
  if(mysql_num_rows($result) > 0){
    echo "<center>
    <h2>Item Report</h2>
      <table border='1;solid'>
        <tr height='50'>
          <th> Area</th>
          <th> ID</th>
          <th> Description</th>
          <th> Quantity</th>
          <th> Remarks</th>
        </tr>
      "; 

            while($row = mysql_fetch_array($result)){
            ?>      
                  <tr>
                  <?php
                  $area_query = mysql_query("SELECT * FROM area_dept where area_id='".$area_id."'");
                   if(mysql_num_rows($area_query) > 0){
                    while($row2 = mysql_fetch_array($area_query)){
                  ?>
                  <td> <?php echo $row2['area_name']; ?></td>
                  <?php 
                    }
                  }
                  ?>
                    <td> <?php echo $row['item_id']; ?></td>
                    <td> <?php echo $row['item_description'] ?></td>
                    <td> <?php echo $row['item_quantity'] ?></td>
                    <td> <?php echo $row['item_status']; ?></td>
                  </tr>           
            <?php
                }
                echo "</table></center>";  
              }
          
            
           ?>      