<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$areaObj = new Area(); 
$areas = $areaObj->getAll();
$error = false;

$index = 1;

$areasArray = [];

$departmentObj   = new Department();

while ($area = $areas->fetch_assoc()) {
  $areasArray[$index]['id'] = $area['id'];
  $areasArray[$index]['name'] = $area['name'];
  $index++;
}

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Requsistions</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Requsistions</a>
              </li>
              <li class="active">
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>">Add A Requisition</a>
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
            <h4 class="panel-title">Add Requisition</h4>
          </div>
          <div class="panel-body">
            <fieldset>
                <form id='requisition_form' action ="<?php echo Link::createUrl('Controllers/AddRequisition.php'); ?>" method="post">
                    
                    <div class="control-group">
                        <label class='control-label' for="type">Requisition Type</label>
                        <select id='requisition_type' class='form-control' name='requisition_type' required>
                            <option value=''>Select Requisition Type</option>
                            <?php foreach (RequisitionUtility::getRequisitionTypes() as $type) { ?>
                              <option value="<?php echo $type; ?>" ><?php echo $type; ?> Requisition</option>
                            <?php } ?>
                        </select>
                        <p class="help-block"></p>
                    </div>

                    <!-- Item Requisition -->
                    <div id="itemRequisition">
                        <div class="control-group" id='itemRequisitionType'>
                            <label class='control-label' for="type">Item Type</label>
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <select id='type' class='form-control' name='type'>
                                        <option value=''>Select Item Type</option>
                                        <?php foreach (StockUtility::getStockTypes() as $type) { ?>
                                          <option value="<?php echo $type; ?>" ><?php echo $type; ?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="help-block"></p>
                                </div>
                            </div>
                            <p class="help-block" style='margin: 0px 10px;'></p>
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

                        <div class="control-group" id='newItemRequisitionForm' style='display:block;'>
                          <div class="row">
                              <div class='col-lg-12'>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="panel panel-default">
                                              <div class="panel-heading">
                                                  <p class='panel-title'>Attached Items In Item Requisition</p>
                                              </div>
                                              <div class="panel-body">
                                                  <table class="requisitionItems item_list table table-hover table-striped table-bordered">
                                                      <thead>
                                                          <tr class='itemForm'>
                                                              <th>Name</th>
                                                              <th>Amount/Unit (Php)</th>
                                                              <th>Quantity</th>
                                                              <th>Unit</th>
                                                              <th>Action</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <tr class='itemForm' data-id=''>
                                                              <td class='col-md-3'>
                                                                  <div class="control-group">
                                                                      <input class='form-control' name="name" id="name" type="text" placeholder="Item Name" value="" />
                                                                      <p class="help-block"></p>
                                                                  </div>
                                                              </td>
                                                              <td class='col-md-1'>
                                                                  <div class="control-group">
                                                                      <input class='form-control' min=1 name="amount" id="amount" type="decimal" placeholder="Amount" />
                                                                      <p class="help-block"></p>
                                                                  </div>
                                                              </td>
                                                              <td class='col-md-2'>
                                                                  <div class="control-group">
                                                                      <input class='form-control' min=1 name="quantity" id="quantity" type="number" placeholder="Quantity" />
                                                                      <p class="help-block"></p>
                                                                  </div>
                                                              </td>
                                                              <td class='col-md-2'>
                                                                  <div class="control-group">
                                                                      <input class='form-control' name="unit" id="unit" type="text" placeholder="Unit" />
                                                                      <p class="help-block"></p>
                                                                  </div>
                                                              </td>
                                                              <td class='col-md-1'>
                                                                  <button type='button' class="btn btn-sm btn-primary add-item-in-new-requisition"><i class='fa fa-plus'></i> Add</button>
                                                              </td>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-warning"> <i class='fa fa-info'></i> Fix first the issue above in order to add item to stocks.</div>
                        <?php endif ?>
                    </div>

                    <!-- Job Requisition -->
                    <div id="jobRequisition">
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
                                  <div class='alert alert-info'> <i class='fa fa-info'></i> There are no areas yet. Please Add Area First. </div>
                              <?php endif ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='control-label' for="purpose"> Purpose</label>    
                            <textarea id='purpose' name='purpose' class='form-control'></textarea>
                            <p class="help-block"></p>
                        </div>

                        <div id='attached_item_group' class="control-group">
                            <label class='control-label' for="purpose"> Attach Item by searching Item Control Identifier</label>    
                            <div class="form-group input-group">
                                    <span class="input-group-addon">
                                      Control Identifier
                                    </span>
                                    <input placeholder='Enter Control Identifier' id='item_control_number' type="text" class="form-control">
                                    <span class="input-group-btn">
                                      <button type='button' id='search_control_number' class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                      </button>
                                    </span>
                            </div>
                            <p style='display:none;' class="help-block alert alert-danger"></p>
                            <table style='display:none' class="table table-hover table-striped requisitionItems" id='item_table'>
                                <thead>
                                    <tr class='itemForm'>
                                        <th>Item Control Identifier</th>
                                        <th>Item Name</th>
                                        <th>Area</th>
                                        <th>Item Condition</th>
                                        <th>Item Type</th>
                                        <th>Change To</th>
                                        <th>Action</th>
                                     </tr>
                                    <tr id='empty' class='info itemForm'>
                                        <td colspan=6 align=center><label class='label label-primary'>No Item Found</label></td>
                                    </tr>
                                    <tr id='loader' style='display:none' class='itemForm'>
                                        <td colspan=6 align=center><i class='fa fa-spinner fa-spin fa-2x'></i></td>
                                    </tr>
                                    <tr id='result' class='info itemForm'>
                                    </tr>
                                </thead>
                                <tbody id='item_list' class='itemForm'>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-warning"> <i class='fa fa-info'></i> Fix first the issue above in order to add item to stocks.</div>
                        <?php endif ?>
                    </div>

                    <?php if (!$error): ?>
                        <input class='btn btn-primary clear btn-5x pull-right' name="submit" value="Save Requisition" type="submit" />
                    <?php endif ?>
                </form>
                <span id='links'>
                  <input id='searchRequisitionLink' type='hidden' value='<?php echo Link::createUrl('Controllers/SearchRequisition.php'); ?>'/>
                </span>
           </fieldset>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>
       