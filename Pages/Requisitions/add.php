<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$areaObj = new Area(); 
$areas = $areaObj->getAll();

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
                    <div class="control-group" id='itemRequisitionType' style='margin:10px 0px;'>
                        <div class="itemRequisitionTypeDiv" style='padding:10px 20px;'>
                            <label class='control-label' for="type">New Item or For Replace</label>
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <button type='button' id='newItemRequisition' class='btn btn-lg btn-primary'><i class='fa fa-plus'></i> New Item</button> 
                                    <button type='button' id='replaceItemRequisition' class='btn btn-lg btn-warning'><i class='fa fa-edit'></i> For Replace</button>
                                </div>
                            </div>
                            <p class="help-block" style='margin: 0px 10px;'></p>
                        </div>
                    </div>
                    <div class="control-group" id='newItemRequisitionForm' style='display:none;'>
                        <div class="row">
                            <div class='col-lg-12'>
                                <div class="row">
                                    <div class="col-lg-12">
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
                                                            <th>Amount/Unit (Php)</th>
                                                            <th>Quantity</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr data-id=''>
                                                            <td class='col-md-2'>
                                                                <div class="control-group">
                                                                    <select id='type' class='form-control' name='type'>
                                                                        <option value=''>Select</option>
                                                                        <?php foreach (StockUtility::getStockTypes() as $type) { ?>
                                                                          <option value="<?php echo $type; ?>" ><?php echo $type; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <p class="help-block"></p>
                                                                </div>
                                                            </td>
                                                            <td class='col-md-3'>
                                                                <div class="control-group">
                                                                    <input class='form-control' name="name" id="name" type="text" placeholder="Item Name" value="" />
                                                                    <p class="help-block"></p>
                                                                </div>
                                                            </td>
                                                            <td class='col-md-3'>
                                                                <select class='form-control' name='areas' id="area">
                                                                    <option value=''>Select</option>
                                                                    <?php foreach ($areasArray as $key => $area): ?>
                                                                        <option value="<?php echo $area['id']; ?>" ><?php echo $area['name']; ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </td>
                                                            <td>
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
                                                            <td class='col-md-3'>
                                                                <div class="control-group">
                                                                    <select id='status' class='form-control' name='status' > 
                                                                        <option value=''>Select</option>
                                                                        <?php foreach (StockUtility::getStockStatus() as $status) { ?>
                                                                          <option value="<?php echo $status; ?>" ><?php echo $status; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <p class="help-block"></p>
                                                                </div>
                                                            </td>
                                                            <td >
                                                                <button type='button' class="btn btn-sm btn-primary add-item-in-new-requisition"><i class='fa fa-plus'></i></button>
                                                                <!-- <button type='button' class="btn btn-sm btn-warning"><i class='fa fa-minus'></i></button> -->
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
                    <div id='attached_item_group' class="control-group" style='display:none'>
                        <label class='control-label' for="purpose"> Attach Item by searching Item by Control Identifier</label>    
                        <div class="form-group input-group">
                                <span class="input-group-addon">
                                  Item Control Number
                                </span>
                                <input placeholder='Enter Control Number' id='item_control_number' type="text" class="form-control">
                                <span class="input-group-btn">
                                  <button type='button' id='search_control_number' class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                  </button>
                                </span>
                        </div>
                        <p style='display:none;' class="help-block alert alert-danger"></p>
                        <table style='display:none' class="table table-hover table-striped" id='item_table'>
                            <thead>
                                <tr>
                                    <th>Item Control Identifier</th>
                                    <th>Item Name</th>
                                    <th>Area</th>
                                    <th>Item Condition</th>
                                    <th>Item Type</th>
                                        <th>Action</th>
                                 </tr>
                                <tr id='empty' class='info'>
                                    <td colspan=6 align=center><label class='label label-primary'>No Item Found</label></td>
                                </tr>
                                <tr id='loader' style='display:none'>
                                    <td colspan=6 align=center><i class='fa fa-spinner fa-spin fa-2x'></i></td>
                                </tr>
                                <tr id='result' class='info'>
                                </tr>
                            </thead>
                            <tbody id='item_list'>
                            </tbody>
                        </table>
                    </div>

                    <div class="control-group">
                      <?php if (0 != $areas->num_rows): ?>
                              <label class='control-label' for="type">Area</label>
                              <select id='area_id' class='form-control' name='area_id' required>
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

                    <div class="control-group">
                        <label class='control-label' for="purpose"> Purpose</label>    
                        <textarea name='purpose' class='form-control' required></textarea>
                        <p class="help-block"></p>
                    </div>
                    
                    

                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Requisition" type="submit" />
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
  <script type="text/javascript">

  </script>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>
       