<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$itemRequisitionObj = new ItemRequisition();

if (isset($_GET['control_identifier'])) {
  $requisition = $itemRequisitionObj->getAllRequesitionByControlNumber($_GET['control_identifier'])->fetch_assoc();
} else {
  throw new Exception('Page Not Found!');
}

$areaObj   = new Area();
$areas = $areaObj->getAll();

$areaParams = [];
?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Approve Requisition</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Requisition</a>
              </li>
              <li class="active">
                  <i class='fa fa-tasks'></i> <a href="">Approve Requisition</a>
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
            <h4 class="panel-title">Approve Requisition</h4>
          </div>
          <div class="panel-body">
            <?php if ($areas && 0 != $areas->num_rows) { ?>
            <fieldset>
                <form action ="<?php echo Link::createUrl('Controllers/AddStock.php'); ?>" method="post">                    
                    <fieldset>
                      <legend>Requisition Details</legend>
                      <div class="row">
                          <div class='col-lg-12'>
                              <div class="row">
                                  <div class='col-lg-6'>
                                    <p><b>Control Identifier</b></p>
                                  </div>
                                  <div class='col-lg-6'>
                                    <?php echo $requisition['requisition_control_identifier'];?>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class='col-lg-6'>
                                    <p><b>Requester Name</b></p>
                                  </div>
                                  <div class='col-lg-6'>
                                    <?php echo RequesterUtility::getFullName($requisition);?>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class='col-lg-6'>
                                    <p><b>Purpose</b></p>
                                  </div>
                                  <div class='col-lg-6'>
                                    <?php echo $requisition['requisition_purpose'];?>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </fieldset>
                    <fieldset>
                      <legend class='clearfix '>Add Item to Requisition</legend>
                      <div class="row">
                          <div class='col-lg-12'>
                              <div class="row">
                                  <div class="col-lg-5" id='approve_requisition_items_template'>
                                      <div class="panel panel-primary approve_requisition_item">
                                          <div class="panel-heading">
                                            <h3 class="panel-title">Item</h3>
                                          </div>
                                          <div class="panel-body">
                                            <div class="control-group">
                                                <label class='control-label' for="type">Item Type</label>
                                                <select id='type' class='form-control' name='type' required>
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
                                            
                                            <div class="control-group">
                                                <label>Area</label>  
                                                <select id='area_id' name='area_id' class='form-control' required>
                                                    <option value=''>Select Area</option>
                                                    <?php 
                                                        if ($areas) {
                                                          while ($area =  $areas->fetch_assoc()) {
                                                              $areaParams[] = [ 'id' => $area['id'], 'name' => $area['name'] ];
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
                                                <select id='status' class='form-control' name='status' required> 
                                                    <option value=''>Select Item Status</option>
                                                    <?php foreach (StockUtility::getStockStatus() as $status) { ?>
                                                      <option value="<?php echo $status; ?>" ><?php echo $status; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                            <button id='attach_item_to_item_requisition_btn' type='button' class='btn btn-primary btn-large pull-right'><i class='fa fa-plus'></i> Add Item To Requisition</button> 
                                            <span>
                                                <input type='hidden' id='attach_item_to_requisition_url' value="<?php echo Link::createUrl('Controllers/AttachItemToRequisition.php'); ?>" />
                                            </span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-lg-7">
                                      <div class="panel panel-default">
                                          <div class="panel-heading">
                                              <p class='panel-title'>Attached Items In Item Requisition</p>
                                          </div>
                                          <div class="panel-body">
                                              <table class="item_list table table-hover table-striped table-bordered">
                                                  <thead>
                                                      <tr>
                                                          <th>Type</th>
                                                          <th>Name</th>
                                                          <th>Area</th>
                                                          <th>Quantity</th>
                                                          <th>Status</th>
                                                          <th>Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <tr data-id=''>
                                                          <td>/index.html</td>
                                                          <td>1265</td>
                                                          <td>32.3%</td>
                                                          <td>$321.33</td>
                                                          <td>32.3%</td>
                                                          <th>
                                                              <button type='button' class="btn btn-sm btn-warning"><i class='fa fa-minus'></i> Remove</button>
                                                          </th>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                    </fieldset>
                    <button type='button' class='btn btn-primary clear btn-lg pull-left' name="submit" class="formbutton">
                      <i class='fa fa-thumbs-up'></i> Approve Requisition
                    </button>
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
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>
       