<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

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
                        <select id='requisition_type' class='form-control' name='type' required>
                            <option value=''>Select Requisition Type</option>
                            <?php foreach (RequisitionUtility::getRequisitionTypes() as $type) { ?>
                              <option value="<?php echo $type; ?>" ><?php echo $type; ?> Requisition</option>
                            <?php } ?>
                        </select>
                        <p class="help-block"></p>
                    </div>

                    <div class="control-group">
                        <label class='control-label' for="purpose"> Purpose</label>    
                        <textarea name='purpose' class='form-control' required></textarea>
                        <p class="help-block"></p>
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
       