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
            <li class="active">Add Record</li>
            <li><a href="account_add.php">Manage Users</a></li>
          </ol>
          <h1>Manage Users</h1>

          <div class="row">
            <div class="col-md-12">
              
              <div class="table-responsive" >
                
                
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Create Item Record</h4>
                  </div>
                  <div class="panel-body">
                    <?php if($_POST['submit']){

                          $iid = mysql_real_escape_string($_POST['item_id']);
                          $iarea = mysql_real_escape_string($_POST['item_area']);
                          $idescr = mysql_real_escape_string($_POST['item_descr']);
                          $iquantity = mysql_real_escape_string($_POST['item_quantity']);
                          $istatus = mysql_real_escape_string($_POST['item_status']);
                          $areaid = mysql_real_escape_string($_POST['area_id']);

                          $que = "Select item_id from items where item_id='".$iid."'";
                          $res = mysql_query($que) or die("YEHET");
                          if(mysql_num_rows($res)){
                            echo"
                            <script>
                            alert('Item already exist!');
                            </script>
                            <meta http-equiv='refresh' content='0;url=item_add.php'>
                            ";
                            }
                          
                          
                          else if((int)$iid){
                            $query = "INSERT INTO items(item_id, item_area, item_description, item_quantity, item_status, area_id) VALUES('".$iid."','".$iarea."', '".$idescr."','".$iquantity."','".$istatus."','".$areaid."')";
                            $result = mysql_query($query) or die ("Error in query:" .mysql_error());
                          echo"
                            <script>
                            alert('Record Successfully Added!');
                            </script>
                            <meta http-equiv='refresh' content='0;url= allitems.php'>
                            ";
                          
                          }
                          else{
                            echo"<script>
                              alert('Wrong input! Please enter a number for item ID.');
                              </script>
                              <meta http-equiv='refresh' content='0;url= item_add.php'>";
                            }
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