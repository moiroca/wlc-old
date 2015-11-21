<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Assets.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
  <?php Assets::renderCss('templatemo_main.css'); ?>
  <?php Assets::renderJs('confirm.js'); ?>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT']."/includes/collapse_header.php" ;?>
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
                    <?php 

                      if ($_POST['submit']) {

                          $iid        = $db->real_escape_string($_POST['item_id']);
                          $iarea      = $db->real_escape_string($_POST['item_area']);
                          $idescr     = $db->real_escape_string($_POST['item_descr']);
                          $iquantity  = $db->real_escape_string($_POST['item_quantity']);
                          $istatus    = $db->real_escape_string($_POST['item_status']);
                          $areaid     = $db->real_escape_string($_POST['area_id']);

                          $query = "Select item_id from items where item_id=$iid ";

                          $result = $db->query($query);

                          if ($result->fetch_assoc()) {

                            $_SESSION['record_already_exist'] = true;
                            header('location: '.Link::createUrl('Pages/Items/items.php'));      
                          } else if ((int)$iid) {
                            
                            $query = "INSERT INTO items(item_id, item_area, item_description, item_quantity, item_status, area_id) VALUES('".$iid."','".$iarea."', '".$idescr."','".$iquantity."','".$istatus."','".$areaid."')";
                            $result = $db->query($query);
                            
                            $_SESSION['record_successful_added'] = true;
                            header('location: '.Link::createUrl('Pages/Items/items.php'));      
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