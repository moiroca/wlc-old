<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Area.php';

include $_SERVER['DOCUMENT_ROOT'].'/Utilities/StockUtility.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$areaObj   = new Area();
$areas = $areaObj->getAll();

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Stocks</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Stocks</a>
              </li>
              <li class="active">
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Stocks/add.php'); ?>">Add A Item</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <div class="col-md-12 col-sm-12 margin-bottom-30">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">Add Item</h4>
          </div>
          <div class="panel-body">
            <?php if ($areas && 0 != $areas->num_rows) { ?>
            <fieldset>
                <form action ="<?php echo Link::createUrl('Controllers/AddStock.php'); ?>" method="post">                    
                    <div class="control-group">
                        <label class='control-label' for="type">Item Type</label>
                        <select class='form-control' name='type' required>
                            <option value=''>Select Item Type</option>
                            <?php foreach (StockUtility::getStockTypes() as $type) { ?>
                              <option value="<?php echo $type; ?>" ><?php echo $type; ?></option>
                            <?php } ?>
                        </select>
                        <p class="help-block"></p>
                    </div>

                    <div class="control-group">
                        <label class='control-label' for="name"> Name</label>    
                        <input class='form-control' name="name" id="name" type="text" placeholder="Tool Name" required="required" value="" />
                        <p class="help-block"></p>
                    </div>
                    
                    <div class="control-group">
                        <label>Area</label>    
                        <select name='area_id' class='form-control' required>
                            <option value=''>Select Area</option>
                            <?php 
                                if ($areas) {
                                  while ($area =  $areas->fetch_assoc()) {
                                    ?>
                                      <option value='<?php echo $area['id']; ?>' ><?php echo $area['name']; ?></option>
                                    <?php
                                  }
                                } 
                            ?>
                        </select>
                        <p class="help-block"></p>
                    </div>

                    <div class="control-group">
                        <label>Quantity:</label>
                        <input class='form-control' min=1 name="quantity" id="quantity" type="number" placeholder="Quantity" required="required"/>
                        <p class="help-block"></p>
                    </div>

                    <div class="control-group">
                        <label class='control-label' for="status">Status:</label>
                        <select class='form-control' name='status' required> 
                            <option value=''>Select Item Status</option>
                            <?php foreach (StockUtility::getStockStatus() as $status) { ?>
                              <option value="<?php echo $status; ?>" ><?php echo $status; ?></option>
                            <?php } ?>
                        </select>
                        <p class="help-block"></p>
                    </div>
                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Stock" type="submit" />
                </form>
           </fieldset>
           <?php } else { ?>
                <div class="alert alert-info"> Please Add Area First Before Adding Item To Stock. </div>
            <?php } ?>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
<?php Template::footer(); ?>
       