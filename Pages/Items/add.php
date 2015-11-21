<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Assets.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
  <?php Assets::renderCss('templatemo_main.css'); ?>
  <?php Assets::renderCss('add_item.css'); ?>
  <?php Assets::renderJs('confirm.js'); ?>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT']."/includes/collapse_header.php" ;?>
      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li class="active">Add Record</li>
            <li><a href="#">Manage Items</a></li>
          </ol>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <div class="col-md-12 col-sm-12 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Add Item</h4>
                  </div>
                  <div class="panel-body">
                    <fieldset>
                        <form action ="<?php echo Link::createUrl('Controllers/AddItem.php'); ?>" method="post">
                            <div class="control-group">
                                <label class='control-label' for="item_id">Item ID:</label>    
                                <div class="control-group">
                                    <input class='form-control' name="item_id" id="item_id" type="item_id" placeholder="Item ID" required="required" value="<?php echo time(); ?>" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class='control-label' for="item_id">Area/Department:</label>    
                                <div class="control-group">
                                    <select name='area_id' class='form-control'>
                                        <?php 

                                          $areaquery = $db->query('Select * from area_dept where area_status!="Deleted"');
                                            
                                            if ($areaquery->fetch_assoc()) {
                                              while ($area_status =  $areaquery->fetch_assoc()) {
                                                ?>
                                                  <option value='<?php echo $area_status['area_id']; ?>' ><?php echo $area_status['area_name']; ?></option>
                                                <?php
                                              }
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class='control-label' for="item_area">Room Area:</label>
                                <div class="control-group">
                                    <input class='form-control' name="item_area" id="item_area" type="text" placeholder="Area" required="required"/>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class='control-label' for="item_descr">Description:</label>
                                <div class="control-group">
                                    <input class='form-control' name="item_descr" id="item_descr" type="text" placeholder="Description" required="required"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class='control-label' for="item_quantity">Quantity:</label>
                                <div class="control-group">
                                    <input class='form-control' name="item_quantity" id="item_quantity" type="text" placeholder="Quantity" required="required"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class='control-label' for="item_status">Status:</label>
                                <div class="control-group">
                                    <select class='form-control' name='item_status'>
                                        <?php 
                                        
                                        $itemQuery = $db->query('Select * from itemstatus where item_status!="Deleted"');
                                            
                                            if ($itemQuery->fetch_assoc()) {
                                              while ($itemStatus =  $itemQuery->fetch_assoc()) {
                                              ?>
                                                  <option value='<?php echo $itemStatus['item_status']; ?>' ><?php echo $itemStatus['item_status']; ?></option>
                                              <?php
                                              }
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class='control-label' ></label>
                                <div class="control-group">
                                    <input class='btn btn-primary btn-large pull-right' name="submit" style="margin-left: 150px;" class="formbutton" value="Add" type="submit" />
                                </div>
                            </div>
                        </form>
                   </fieldset>
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
    </div>
  </div>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/templatemo_script.js"></script>
  </body>
</html>