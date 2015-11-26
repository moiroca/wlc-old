<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Area.php';

include $_SERVER['DOCUMENT_ROOT'].'/Utilities/StockUtility.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Users</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">User Accounts</a>
              </li>
              <li class="active">
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Users/add.php'); ?>">Add A Item</a>
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
            <?php
                $areaObj   = new Area();
                $areas = $areaObj->getAll();
            ?>
            
                <form action ="<?php echo Link::createUrl('Controllers/AddStock.php'); ?>" method="post">
                    <fieldset>
                      <legend>User Information</legend>
                      <div class="control-group">
                          <label class='control-label' for="name"> First Name</label>    
                          <input class='form-control' name="name" id="first_name" type="text" placeholder="First Name" required="required" value="" />
                          <p class="help-block"></p>
                      </div>
                      <div class="control-group">
                          <label class='control-label' for="name"> Last Name</label>    
                          <input class='form-control' name="name" id="last_name" type="text" placeholder="Last Name" required="required" value="" />
                          <p class="help-block"></p>
                      </div>
                      <div class="control-group">
                          <label class='control-label' for="name"> Middle Name</label>    
                          <input class='form-control' name="name" id="middle_name" type="text" placeholder="Middle Name" required="required" value="" />
                          <p class="help-block"></p>
                      </div>
                    </fieldset>

                    <fieldset>
                        <legend>School Information</legend>

                        <div class="control-group">
                            <label class='control-label' for="status"> User Type</label>
                            <select class='form-control' name='status' required> 
                                <option value=''>Select User Type</option>
                                <?php foreach (StockUtility::getStockStatus() as $status) { ?>
                                  <option value="<?php echo $status; ?>" ><?php echo $status; ?></option>
                                <?php } ?>
                            </select>
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
                    </fieldset>

                    <fieldset>
                        <legend>User Credentials</legend>

                        <div class="control-group">
                            <label class='control-label' for="name"> Username</label>    
                            <input class='form-control' name="username" id="username" type="text" placeholder="Username" required="required" value="" />
                            <p class="help-block"></p>
                        </div>

                        <div class="control-group">
                            <label class='control-label' for="name"> Password</label>    
                            <input class='form-control' name="password" id="password" type="text" placeholder="Password" required="required" value="" />
                            <p class="help-block"></p>
                        </div>
                    </fieldset>

                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Stock" type="submit" />
                </form>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
<?php Template::footer(); ?>
       