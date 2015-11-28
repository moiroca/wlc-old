<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$tools = new Tools();
$stocks = new Stocks();

if (!isset($_GET['name'])) { throw new Exception('Error 404: Page Not Found!'); }

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
                  <i class="fa fa-table"></i> <a href="<?php echo Link::createUrl('Pages/Stocks/Tools/tools.php'); ?>">Tools</a>
              </li>
              <li>
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Stocks/add.php'); ?>">Add Item</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">

        <?php 

            $result = $stocks->getStocks([
                          [
                            'field' => '`stocks`.`status`',
                            'value' => Constant::STOCK_DELETED,
                            'isEqual' => false,
                            'andOrWhere' => '',
                          ],
                          [
                            'field' => '`stocks`.`name`',
                            'value' => $_GET['name'],
                            'isEqual' => true,
                            'andOrWhere' => 'AND',
                          ],
                      ]);
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
                <th> Control Number </th>
                <th> Area</th>
                <th> Name</th>
                <th> Item Status</th>
                <th> Action </th>
              </tr>
          </thead>
          <tbody>
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <tr>
                    <td> <?php echo $item['stock_control_number']; ?></td>
                    <td> <?php echo $item['area_name']; ?></td>
                    <td> <?php echo $item['stock_name']; ?></td>
                    <td> <?php echo $item['stock_status']; ?></td>
                    <td> 
                      <a href="#" class='btn btn-sm btn-default'>
                        <i class='fa fa-edit'></i> Edit
                      </a> 
                      <a href="#" class='btn btn-xs btn-warning'>
                        <i class='fa fa-minus'></i> Delete
                      </a>
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