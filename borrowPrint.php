<?php 
session_start();
  include_once("../php/configure.php");
  
  if(!isset($_SESSION['login'])){
    header("Location: index.php");
  }

  if($_SESSION['login'] == "Borrower"){
    $out = '<a href="php/configure.php"> Sign out </a>';
  }
  else if($_SESSION['login'] == "Admin"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "GSD Officer"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "Employee"){
    $out = '<a href="../php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "President"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else{
    $out = '<a href="index.php"> Sign out </a>';
  }

              $result = mysql_query("SELECT * FROM borrow ");
              
              
              if(mysql_num_rows($result) > 0)
                { echo "<center>
                    <h2>Borrowing Report</h2>
                    <table border='1;solid'>
                    <tr height='50'>
                    
                           <th> Select</th>
                           <th> Request ID</th>
                           <th> Requested By</th>
                           <th> Request Date</th>
                           <th> Area</th>
                           <th> Item</th>
                           <th> Quantity</th>
                           <th> Status</th>
                    </tr>"; ?>
                  </thead>
                  <tbody>
            <?php while($row = mysql_fetch_array($result))
                {
            ?>    <tr>
                      <td> <input type='checkbox' name ='checkb[]' value= '<?php echo $row['request_id'] ; ?> '></td>
                      <td> <?php echo $row['request_id']; ?></td>
                      <td> <?php echo $row['requested_by']; ?></td>
                      <td> <?php echo $row['request_date'] ?></td>

                      <?php
                        $area = mysql_query("SELECT * FROM area where area_id = '".$row['area_id']."' ");
                        if(mysql_num_rows($area) > 0){
                           while($row2 = mysql_fetch_array($area)){
                      ?> 
                            <td> <?php echo $row2['area_name'] ?></td>
                      <?php }}?>
                      <?php
                        $item = mysql_query("SELECT * FROM items where item_id = '".$row['item_id']."' ");
                        if(mysql_num_rows($item) > 0){
                           while($row3 = mysql_fetch_array($item)){
                      ?> 
                            <td> <?php echo $row3['item_description'] ?></td>
                      <?php }}?>
                      
                      <td> <?php echo $row['quantity']; ?></td>

                      <?php
                        $stat = mysql_query("SELECT * FROM request_status where reqstat_id = '".$row['request_status']."' ");
                        if(mysql_num_rows($stat) > 0){
                           while($row4 = mysql_fetch_array($stat)){
                      ?> 
                            <td> <?php echo $row4['request_status']; ?></td>
                      <?php }}
             echo "</table></center>";
              }
             }
           ?>      