<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <style type="text/css">.help-block{ color: #f00;}</style>
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
                $departmentObj   = new Department();
                $departments = $departmentObj->getAll();
            ?>
                <form action ="<?php echo Link::createUrl('Controllers/AddUser.php'); ?>" method="post">
                    <fieldset>
                      <legend>User Information</legend>
                      <div class="control-group">
                          <label class='control-label' for="first_name"> First Name</label>    
                          <input class='form-control' name="first_name" id="first_name" type="text" placeholder="First Name" required="required" value="" />
                          <p class="help-block"><?php echo (isset($_SESSION['errors']['first_name'])) ? $_SESSION['errors']['first_name'] : ''; ?></p>
                      </div>
                      <div class="control-group">
                          <label class='control-label' for="last_name"> Last Name</label>    
                          <input class='form-control' name="last_name" id="last_name" type="text" placeholder="Last Name" required="required" value="" />
                          <p class="help-block"><?php echo (isset($_SESSION['errors']['last_name'])) ? $_SESSION['errors']['last_name'] : ''; ?></p>
                      </div>
                      <div class="control-group">
                          <label class='control-label' for="middle_name"> Middle Name</label>    
                          <input class='form-control' name="middle_name" id="middle_name" type="text" placeholder="Middle Name" required="required" value="" />
                          <p class="help-block"><?php echo (isset($_SESSION['errors']['middle_name'])) ? $_SESSION['errors']['middle_name'] : ''; ?></p>
                      </div>
                    </fieldset>

                    <fieldset>
                        <legend>School Information</legend>
                        <input id='getDepartmentHeadLink' type='hidden' value='<?php echo Link::createUrl('Controllers/GetDepartmentHead.php'); ?>'>   
                        <div class="control-group">
                          <label>Department</label>    
                          <?php if (0 != $departments->num_rows): ?>
                                <select id='department_id' name='department_id' class='form-control' required>
                                  <option value=''>Select Department</option>
                                  <?php 
                                      if ($departments) {
                                        while ($department =  $departments->fetch_assoc()) {
                                          ?>
                                            <option value='<?php echo $department['id']; ?>' ><?php echo $department['name']; ?></option>
                                          <?php
                                        }
                                      } 
                                  ?>
                              </select>
                          <?php else: ?>
                              <div class="alert alert-info">
                                  There are no department. Please add A Department first.
                              </div>
                          <?php endif ?>
                          <p class="help-block"><?php echo (isset($_SESSION['errors']['area_id'])) ? $_SESSION['errors']['area_id'] : ''; ?></p>
                      </div>

                      <div class="control-group">
                          <?php 
                              $departmentHead = $departmentObj->getDepartmentHeadByDepartmentId(1); 
                              $departmentHead = $departmentHead->fetch_assoc();
                          ?>
                          
                          <div id="departmentHead" style='display:none'>
                              <p >Current Department Head: <b ></b> </p>
                              <div class="alert alert-info"> <i class='fa fa-info'></i> There is no set Department Head.</div>
                          </div>
                      </div>
                      <div class="control-group">
                          <label class='control-label' for="user_type"> User Type</label>
                          <select class='form-control' name='user_type' required> 
                              <option value=''>Select User Type</option>
                              <?php foreach (UserUtility::getUserTypes() as $type) { ?>
                                <?php if ($type == Constant::USER_EMPLOYEE): ?>
                                    <option value="<?php echo $type; ?>" >Other</option>
                                <?php else: ?>
                                    <option value="<?php echo $type; ?>" ><?php echo $type; ?></option>  
                                <?php endif ?>
                              <?php } ?>
                          </select>
                          <p class="help-block"><?php echo (isset($_SESSION['errors']['user_type'])) ? $_SESSION['errors']['user_type'] : ''; ?></p>
                      </div>
                    </fieldset>

                    <fieldset>
                        <legend>User Credentials</legend>

                        <div class="control-group">
                            <label class='control-label' for="name"> Username</label>    
                            <input class='form-control' name="username" id="username" type="text" placeholder="Username" required="required" value="" />
                            <p class="help-block"><?php echo (isset($_SESSION['errors']['username'])) ? $_SESSION['errors']['username'] : ''; ?></p>
                        </div>

                        <div class="control-group">
                            <label class='control-label' for="name"> Password</label>    
                            <input class='form-control' name="password" id="password" type="password" placeholder="Password" required="required" value="" />
                            <p class="help-block"><?php echo (isset($_SESSION['errors']['password'])) ? $_SESSION['errors']['password'] : ''; ?></p>
                        </div>

                        <div class="control-group">
                            <label class='control-label' for="name"> Confirm Password</label>    
                            <input class='form-control' name="cpassword" id="cpassword" type="password" placeholder="Confirm Password" required="required" value="" />
                            <p class="help-block"><?php echo (isset($_SESSION['errors']['cpassword'])) ? $_SESSION['errors']['cpassword'] : ''; ?></p>
                            <p class="help-block"><?php echo (isset($_SESSION['errors']['matching'])) ? $_SESSION['errors']['matching'] : ''; ?></p>
                        </div>
                    </fieldset>

                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save User" type="submit" />
                </form>
                <?php if (isset($_SESSION['errors'])) { unset($_SESSION['errors']); }; ?>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
<?php Template::footer(['user.js', 'Department/Department.js']); ?>
       