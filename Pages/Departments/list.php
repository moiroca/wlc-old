<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$departments = new Department();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"> Departments</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#"> Departments</a>
              </li>
              <li>
                  <i class="fa fa-plus"></i>  <a href="<?php echo Link::createUrl('Pages/Departments/add.php'); ?>"> Add Department</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">

        <?php 
            $result = $departments->getAll();
        ?>

        <?php if (isset($_SESSION['record_successful_added'])) { ?>
        <?php unset($_SESSION['record_successful_added']); ?>
            <div class="alert alert-success">
                Item Record Succesfully Added.
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['something_wrong'])) { ?>
        <?php unset($_SESSION['something_wrong']); ?>
            <div class="alert alert-danger">
                The System is still in development mode. Expect more bugs to come. 
            </div>
        <?php } ?>
        <table class="table table-striped table-hover table-bordered">
          <thead>
              <tr id='th'>
                <th> Name</th>
                <th> Action </th>
              </tr>
          </thead>
          <tbody>
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <tr>
                    <td> <?php echo $item['name']; ?></td>
                    <td> 
                      <a class="btn btn-sm btn-info"> Edit </a>
                      <a class="btn btn-sm btn-warning"> Delete </a>
                    </td>
                  </tr>  
                <?php } ?>
            <?php } else { ?>
                  <tr>
                      <td colspan=2>
                          <div class="alert alert-info">
                              There are no items found.
                          </div>
                      </td>
                  </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php Template::footer(); ?>