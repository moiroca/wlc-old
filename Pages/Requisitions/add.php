<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Utilities/Constant.php';
include $_SERVER['DOCUMENT_ROOT'].'/Utilities/RequisitionUtility.php';

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
                <form action ="<?php echo Link::createUrl('Controllers/AddRequisition.php'); ?>" method="post">
                    
                    <div class="control-group">
                        <label class='control-label' for="type">Requisition Type</label>
                        <select class='form-control' name='type' required>
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
                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Requisition" type="submit" />
                </form>
           </fieldset>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
<?php Template::footer(); ?>
       