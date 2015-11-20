<?php date_default_timezone_set("Asia/Hong_Kong");
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
  <?php include("../includes/header2.php");?>

      
      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
         
          <h1>Requisition For <?php echo $_SESSION['area_name'];?></h1>

          <div class="row">
            <div class="col-md-12">
              
              <div class="table-responsive" >
                
                
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Requisition</h4>
                  </div>
                  <div class="panel-body">
                    <?php if($_POST['submit']){
                      
                      $reqID = count($_POST['item_id']);
                      for($i=0; $i<$reqID; $i++) 
                      {

                      $orig = $_SESSION['origQuantity'][$i];
                      $iid = mysql_real_escape_string($_POST['item_id'][$i]);
                      $iarea = mysql_real_escape_string($_POST['item_area'][$i]);
                      $iquantity = mysql_real_escape_string($_POST['item_quantity'][$i]);
                      $istatus = mysql_real_escape_string($_POST['item_status'][$i]);
                      $ipurpose = mysql_real_escape_string($_POST['item_purpose'][$i]);
                      $areaid = $_SESSION['area_id'];
                     $que2 = mysql_query("SELECT * from items where item_id='".$iid."' and area_id='".$areaid."' and item_id='".$iid."'");
                        if(mysql_num_rows($que2)>0){
                          while($row2 = mysql_fetch_array($que2)){
                          $_SESSION['item_quantity'] = $row2['item_quantity'];
                          
                        }
                      }
                     $origqty =  $_SESSION['item_quantity'];
                     echo $origqty ."-";
                     echo $iquantity ." ";
                     
                      if($istatus == "For Repair"){
                        if($iquantity < $origqty && $ipurpose != ""){
                          $totalquantity = $origqty-$iquantity;

                        $query = "INSERT INTO requisition(area_id, item_id,item_area,item_quantity,item_status,requisition_date,requisition_status, item_purpose) 
                              VALUES ('".$areaid."','".$iid."','".$iarea."','".$iquantity."','".$istatus."', '".date("y-m-d")."', 'Pending', '".$ipurpose."')";
                        $result = mysql_query($query) or die ("Error in query:" .mysql_error());

                        $query3 = mysql_query("SELECT * FROM items where area_id='".$area_id."'");
                        if(mysql_num_rows($query3)>0){
                          mysql_query("Update Items SET item_quantity = '". $totalquantity ."' where item_id='".$iid."'") or die ("Error Updating: " .mysql_error());
                          
                        }
                        
                            echo"
                            <meta http-equiv='refresh' content='0;url= inventory_add.php?area_id=".$_SESSION['area_id']."'>
                            <script>
                            alert('Record Successfully Added!');system.exit(0);
                            </script>
                            
                            "; 
                          }
                          if($iquantity > $origqty){
                      
                          echo"
                          <script>
                            alert('Failed to add your request, Total number of borrowed equipment is equal to zero or Number of For Repair Equipment is more than the total number of Equipment borrowed');
                            system.exit(0);
                          </script>
                          "; //window.location.href("inventory_add.php?area_id=".$_SESSION['area_id']."'");
                        }
                            
                          
                        
                        }
                        
                      
                      else if($istatus == "Good Condition"){
                        echo"<script>
                        <meta http-equiv='refresh' content='0;url= department/area_view.php'>
                          alert('Equipment that are in Good Condition are not added to database.');
                          </script>
                          ";
                      }
                    }
                      
                    }
                             
                  else{
                        echo"<script>
                          alert('Failed to Add this Record.');
                          </script>
                          <meta http-equiv='refresh' content='0;url= department/area_view.php'>";
                        }
                        ?>
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
          <p>Copyright &copy; Soria & Labra.  Credit: www.templatemo.com</p>
        </div>
      </footer>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>