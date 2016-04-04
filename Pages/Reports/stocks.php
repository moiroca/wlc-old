<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$stocks = new Stocks();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$filters = [];

if (isset($_GET['stock_name']) && !empty($_GET['stock_name'])) {
  $filters['name'] = $_GET['stock_name'];
}

if (isset($_GET['item_status']) && !empty($_GET['item_status'])) {
  $filters['status'] = $_GET['item_status'];
}

if (isset($_GET['stock_type']) && !empty($_GET['stock_type'])) {
  $filters['type'] = $_GET['stock_type'];
}

if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
  try {
    $mockDate = date_create($_GET['start_date']);

    if (!$mockDate) {
      throw new Exception('Invalid Start Date Format');
    }
  } catch (Exception $e) {

    die($e->getMessage());
    $_SESSION['error'] = $e->getMessage();
  }

  $filters['start_date'] = $_GET['start_date'];
}

if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
  try {
    $mockDate = date_create($_GET['start_date']);

    if (!$mockDate) {
      throw new Exception('Invalid End Date Format');
    }
  } catch (Exception $e) {
    die($e->getMessage());
    $_SESSION['error'] = $e->getMessage();
  }

  $filters['end_date'] = $_GET['end_date'];
}

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Materials</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Stocks</a>
              </li>
              <li class="active">
                  <i class="fa fa-table"></i> <a href="<?php echo Link::createUrl('Pages/Stocks/Materials/materials.php'); ?>">Materials</a>
              </li>
              <li>
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Stocks/add.php'); ?>">Add Item</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      

      <div class="panel panel-primary">
          <div class="panel-heading">
              <div class="panel-title">Requisitions</div>
          </div>
          <div class="panel-body">
                <?php 

                    $result = $stocks->getAllStockForReport($filters);
                ?>
                <form method='GET' action="" id='SearchForm'>
                    <div class="row">
                        <div class='col-md-2'>
                            <div class='control-group'>
                                <label class="control-label">Stock Name</label>
                                <input name='stock_name' type='text' class='form-control input-sm'>
                            </div>
                        </div>
                        <div class='col-md-2'>
                            <div class='control-group'>
                                <label class="control-label">Item Status</label>
                                <select name='item_status' class='input-sm form-control'>
                                    <option value=""> Select Status </option>
                                    <?php foreach (StockUtility::getStockStatus() as $key => $status): ?>
                                      <option value='<?php echo $status; ?>'><?php echo $status; ?></option>  
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class='control-group'>
                                <label class="control-label">Stock Type</label>
                                <select name='stock_type' class='input-sm form-control'>
                                    <option value=""> Select Type </option>
                                    <option >Material and Equipment</option>
                                    <option >Office Supply</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class='control-group'>
                                <label class="control-label">Start date</label>
                                <input name='start_date' type='date' class='form-control input-sm' placeholder='YYYY-MM-DD'>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class='control-group'>
                                <label class="control-label">End date</label>
                                <input name='end_date' type='date' class='form-control input-sm' placeholder='YYYY-MM-DD'>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class='control-group'>
                              <input style='margin-top:22px;' type='submit' class='btn btn-primary form-control' value="Search">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                  <table style='margin-top:20px;' class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr id='th'>
                          <th> #</th>
                          <th> Name</th>
                          <th> Status </th>
                          <th> Stock Type </th>
                          <th> Datetime Added</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if ($result && 0 != $result->num_rows) { ?>
                          <?php $number = 1; ?>
                          <?php  while ($item = $result->fetch_assoc()) { ?>
                            <tr>
                              <td> <?php echo $number; ?></td>
                              <td> <?php echo $item['name']; ?></td>
                              <td> <?php echo $stocks->getItemCurrentStatus($item['id'])->fetch_assoc()['status']; ?></td>
                              <td> <?php echo $item['type']; ?></td>
                              <td> 
                                  <?php echo $item['datetime_added']; ?>
                              </td>
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
    </div>
  </div>
<?php Template::footer(); ?>