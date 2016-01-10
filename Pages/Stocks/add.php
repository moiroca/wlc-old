<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$error = false;
$areaObj = new Area(); 
$areas = $areaObj->getAll();

$departmentObj   = new Department();

$index = 1;
$areasArray = [];

while ($area = $areas->fetch_assoc()) {
  $areasArray[$index]['id'] = $area['id'];
  $areasArray[$index]['name'] = $area['name'];
  $index++;
}


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
                        <input class='form-control' name="name" id="name" type="text" placeholder="Item Name" required="required" value="" />
                        <p class="help-block"></p>
                    </div>
                    
                    <?php
                        $departments = $departmentObj->getAll();
                    ?>
                    <div class="control-group">
                      <label>Department</label>    
                          <input type='hidden' id='getAreaUrl' value='<?php echo Link::createUrl('Controllers/GetArea.php'); ?>' />

                          <?php  if (0 != $departments->num_rows) { ?>
                          <select name='department_id' class='form-control department_id'>
                            <option value=''>Select Department</option>
                            <?php while ($department =  $departments->fetch_assoc()) { ?>
                                      <option value='<?php echo $department['id']; ?>' ><?php echo $department['name']; ?></option>
                            <?php } ?>
                        </select>
                        <?php } else { ?>
                            <?php $error = true; ?>
                            <div class="alert alert-info"> There are no Departments. Please Add A Department First.</div>
                        <?php } ?>
                        <p class="help-block"><?php echo (isset($_SESSION['errors']['area_id'])) ? $_SESSION['errors']['area_id'] : ''; ?></p>
                    </div>

                    <div class="control-group areas">
                        <div class="control-group">
                          <?php if (0 != $areas->num_rows): ?>
                                  <label class='control-label' for="type">Area</label>
                                  <select class='form-control area_id' name='area_id'>
                                      <option value=''>Select Area</option>
                                      <?php foreach ($areasArray as $key => $area): ?>
                                          <option value="<?php echo $area['id']; ?>" ><?php echo $area['name']; ?></option>
                                      <?php endforeach ?>
                                  </select>
                                  <p class="help-block"></p>
                          <?php else : ?>
                              <?php $error = true; ?>
                              <div class='alert alert-info'> <i class='fa fa-info'></i> There are no areas yet. Please Add Area First. </div>
                          <?php endif ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label>Quantity:</label>
                        <input class='form-control' min=1 name="quantity" id="quantity" type="number" placeholder="Quantity" required="required"/>
                        <p class="help-block"></p>
                    </div>

                    <div class="control-group">
                        <label>Price Per Unit (Php):</label>
                        <input class='form-control' min=1 name="price" id="price" type="number" step='0.01' placeholder="Price" required="required"/>
                        <p class="help-block"></p>
                    </div>

                    <div class="control-group">
                        <label>Unit</label>
                        <input class='form-control' name="unit" id="unit" type="text" placeholder="e.g. M, Pc, Kg, G," required="required"/>
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
                    <?php if (!$error): ?>
                        <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Stock" type="submit" />
                    <?php else: ?>
                        <div class="alert alert-warning"> <i class='fa fa-info'></i> Fix first the issue above in order to add item to stocks.</div>
                    <?php endif ?>
                    
                </form>
            </fieldset>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>
       