<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$tools = new Tools();
$stocks = new Stocks();

if (!isset($_GET['name']) || !isset($_GET['type'])) { throw new Exception('Error 404: Page Not Found!'); }

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
                  <i class="fa fa-table"></i> <a href="#"><?php echo $_GET['type']; ?></a>
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
                            'field' => '`stocks`.`name`',
                            'value' => $_GET['name'],
                            'isEqual' => true,
                            'andOrWhere' => 'AND',
                          ],
                          [
                            'field' => '`stocks`.`isRequest`',
                            'value' => 'FALSE',
                            'isEqual' => true,
                            'andOrWhere' => 'AND',
                          ],
                          [
                            'field' => '`stocks`.`type`',
                            'value' => $_GET['type'],
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
                <th> #</th>
                <th> Control Number </th>
                <th> Name</th>
                <th> Location </th>
                <th> Item Status</th>
                <?php if (Login::getUserLoggedInType() == Constant::USER_INVENTORY_OFFICER): ?>
                  <th> Action </th>  
                <?php endif ?>
                
              </tr>
          </thead>
          <tbody>
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php $stockRepo = new Stocks(); ?>
                <?php $number = 1; ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <tr>
                    <td> <?php echo $number; ?></td>
                    <td> <?php echo $item['control_number']; ?></td>
                    <td> <?php echo $item['name']; ?></td>
                    <td> 
                       <?php $stockLocations = $stockRepo->getStockLocations($item['id']); ?>
                        <ul>
                            <?php while ($stockLocation = $stockLocations->fetch_assoc()): ?>
                                <li>
                                  <label class="label label-info"><?php echo $stockLocation['area_name']; ?></label>
                                  <?php if (!$stockLocation['area_items_deleted_at']): ?>
                                    <label class="label label-success">Current Location</label>
                                  <?php endif ?>
                                </li>
                            <?php endwhile ?>
                        </ul>
                    </td>
                    <td>  
                          <?php $stockStatuses = $stockRepo->getStockStatus($item['id']); ?>
                          <ul>
                              <?php while ($stockStatus = $stockStatuses->fetch_assoc()): ?>
                                  <li>
                                    <label class="label label-info"><?php echo $stockStatus['status']; ?></label>
                                    <?php if (!$stockStatus['deleted_at']): ?>
                                      <label class="label label-success">Current Status</label>
                                    <?php endif ?>
                                  </li>
                              <?php endwhile ?>
                          </ul>
                    </td>
                    <?php if (Login::getUserLoggedInType() == Constant::USER_INVENTORY_OFFICER): ?>
                      <td> 
                        <a href="#" class='btn btn-sm btn-default'> <i class='fa fa-edit'></i> Edit </a>
                      </td>
                    <?php endif ?>
                  </tr>  
                <?php $number++; ?>
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