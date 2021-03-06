<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$departmentObj   = new Department();
$departments = $departmentObj->getAll();

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Areas</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Areas</a>
              </li>
              <li class="active">
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Areas/add.php'); ?>">Add Areas</a>
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
            <h4 class="panel-title">Add Area</h4>
          </div>
          <div class="panel-body">
            <fieldset>
                <form id='requisition_form' action ="<?php echo Link::createUrl('Controllers/AddArea.php'); ?>" method="post">
                    <div class="control-group">
                          <label>Department</label>    
                          <?php  if (0 != $departments->num_rows) { ?>
                          <select name='department_id' class='form-control' required>
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

                    <div class="control-group">
                        <label class='control-label' for="name"> Name</label>    
                        <input type='text' name='name' class='form-control' required />
                        <p class="help-block"></p>
                    </div>

                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Area" type="submit" />
                </form>
           </fieldset>
          </div>
        </div>                
      </div>

      </div>
      
    </div>
  </div>
  <script type="text/javascript">

  </script>
<?php Template::footer(); ?>
       