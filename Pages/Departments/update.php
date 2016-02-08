<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$departmentRepo = new Department();

if (isset($_GET['department'])) {
  $department = $departmentRepo->getAll(['*'],['id' => $_GET['department']]);

  if ($department && $department->num_rows != 0) {
    $department = $department->fetch_assoc();
  } else {
    echo json_encode(['error' => 'Department Not Found']);  
    die();
  }
  
} else {
  echo json_encode(['error' => 'Department Id not Defined']);
  die();
}

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Departments</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Departments</a>
              </li>
              <li class="active">
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Departments/add.php'); ?>">Add Department</a>
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
            <h4 class="panel-title">Add Department</h4>
          </div>
          <div class="panel-body">
            <fieldset>
                <form id='requisition_form' action ="<?php echo Link::createUrl('Controllers/AddDepartment.php'); ?>" method="post">
                    <input type='hidden' name='department_id' value="<?php echo $department['id']; ?>">
                    <div class="control-group">
                        <label class='control-label' for="name"> Name</label>    
                        <input type='text' name='name' class='form-control' required value="<?php echo $department['name']; ?>"/>
                        <p class="help-block"></p>
                    </div>

                    <input class='btn btn-primary clear btn-5x pull-right' name="submit" class="formbutton" value="Save Department" type="submit" />
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
       