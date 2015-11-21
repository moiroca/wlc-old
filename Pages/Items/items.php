<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Assets.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
            <li><a href="item_add.php">Add Record</a></li>
            <li class="active">Manage Items</li>
          </ol>
          <h1>EQUIPMENT, TOOLS AND MATERIALS</h1>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <?php $result = $db->query("SELECT * FROM items join area_dept on `area_dept`.`area_id`=`Items`.`area_id` where item_status !='Deleted'"); ?>
                
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                      <?php if ($result) { ?>
                            <tr id='th'>
                              <th> ID</th>
                              <th> Area/Department</th>
                              <th> Room Area</th>
                              <th> Description</th>
                              <th> Quantity</th>
                              <th> Remarks</th>
                              <th> Action</th>
                            </tr>
                      <?php } ?>
                  </thead>
                  <tbody>
                    <?php  while ($item = $result->fetch_assoc()) { ?>
                      <tr>
                        <td> <?php echo $item['item_id']; ?></td>
                        <td> <?php echo $item['area_name']; ?></td>
                        <td> <?php echo $item['item_area']; ?></td>
                        <td> <?php echo $item['item_description'] ?></td>
                        <td> <?php echo $item['item_quantity']; ?></td>
                        <td> <?php echo $item['item_status']; ?></td>
                        <td> 
                          <a type="button" class="btn btn-primary btn-sm" href='#'>Edit</a> 
                          <a type="button" class="btn btn-warning btn-sm" href='#'>Delete</a> 
                        </td>
                      </tr>  
                    <?php } ?>
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
      <?php Assets::renderJs('jquery.min.js'); ?>
      <?php Assets::renderJs('bootstrap.min.js'); ?>
      <?php Assets::renderJs('templatemo_script.js'); ?>
  </body>
</html>