<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Tools.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

Login::sessionStart();

$tools = new Tools();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Tools</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Stocks</a>
              </li>
              <li class="active">
                  <i class="fa fa-table"></i> Tools
              </li>
              <li>
                  <i class='fa fa-tasks'></i> <a href="">Add A Tool</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">

        <?php 

            $result = $tools->raw("
              SELECT 
                `stocks`.`name` as stock_name, 
                COUNT(*) as stock_quantity,
                `areas`.`name` as area_name
              FROM 
                stocks 
              JOIN 
                areas 
              ON `areas`.`id`=`stocks`.`id`
              WHERE 
                status != 'Deleted'
              GROUP BY
                `stocks`.`name`
              AND
                `stocks`.`datetime_added`");
        ?>

        <?php if (isset($_SESSION['record_successful_added'])) { ?>
        <?php unset($_SESSION['record_successful_added']); ?>
            <div class="alert alert-success">
                Item Record Succesfully Added.
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['record_already_exist'])) { ?>
        <?php unset($_SESSION['record_already_exist']); ?>
            <div class="alert alert-danger">
                Item ID Already Exist.
            </div>
        <?php } ?>
        <table class="table table-striped table-hover table-bordered">
          <thead>
              <tr id='th'>
                <th> Area</th>
                <th> Name</th>
                <th> Quantity</th>
                <th> Action </th>
              </tr>
          </thead>
          <tbody>
            <?php if ($result) { ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <tr>
                    <td> <?php echo $item['area_name']; ?></td>
                    <td> <?php echo $item['stock_name']; ?></td>
                    <td> <?php echo $item['stock_quantity']; ?></td>
                    <td> 
                      <a type="button" class="btn btn-info btn-sm" href='#'> View All <?php echo ucfirst($item['stock_name']); ?> Tools</a> 
                    </td>
                  </tr>  
                <?php } ?>
            <?php } else { ?>
                  <tr>
                      <td colspan=7>
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