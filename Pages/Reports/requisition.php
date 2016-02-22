<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$requisitionsRepo = new Requisitions();

$filters = [];

if (isset($_GET['requester_name']) && !empty($_GET['requester_name'])) {
  $filters['requester_name'] = $_GET['requester_name'];
}

if (isset($_GET['requisition_status']) && !empty($_GET['requisition_status'])) {
  $filters['requisition_status'] = $_GET['requisition_status'];
}

if (isset($_GET['requisition_type']) && !empty($_GET['requisition_type'])) {
  $filters['requisition_type'] = $_GET['requisition_type'];
}

if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
  try {
    $mockDate = date_create($_GET['start_date']);

    // var_dump($mockDate);
    // die();
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

if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
  die($error);
  unset($_SESSION['error']); 
  $requisitions = null;
} else {
  $requisitions = $requisitionsRepo->getAllRequesition(false, $filters);
}


?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">REPORTS</h1>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Requisitions</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                  <span>
                      <input type="hidden" id="requisition_type" value="<?php echo Constant::REQUISITION_ITEM; ?>"/>
                  </span>
                  <form method='GET' action="" id='SearchForm'>
                      <div class="row">
                          <div class='col-md-2'>
                              <div class='control-group'>
                                  <label class="control-label">Requester Name</label>
                                  <input name='requester_name' type='text' id='filterRequesterName' class='form-control input-sm'>
                              </div>
                          </div>
                          <div class='col-md-2'>
                              <div class='control-group'>
                                  <label class="control-label">Requisition Status</label>
                                  <select name='requisition_status' class='input-sm form-control' id="requisition_status">
                                      <option value=""> Select Status </option>
                                      <?php foreach (RequisitionUtility::getRequisitionStatuses() as $key => $status): ?>
                                        <option value='<?php echo $key; ?>'><?php echo $status; ?></option>  
                                      <?php endforeach ?>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class='control-group'>
                                  <label class="control-label">Requisition Type</label>
                                  <select name='requisition_type' id='search_requisition_type' class='input-sm form-control'>
                                      <option value=""> Select Type </option>
                                      <option value='1'>Job</option>
                                      <option value='2'>Item</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class='control-group'>
                                  <label class="control-label">Start Date</label>
                                  <input name='start_date' type='date' id='filterByStartDate' class='form-control input-sm' placeholder='YYYY-MM-DD'>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class='control-group'>
                                  <label class="control-label">End Date</label>
                                  <input name='end_date' type='date' id='filterByEndDate' class='form-control input-sm' placeholder='YYYY-MM-DD'>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class='control-group'>
                                <input style='margin-top:22px;' type='submit' class='btn btn-primary form-control' value="Search">
                              </div>
                          </div>
                      </div>
                  </form>
                  <?php if (isset($error)): ?>
                      <div class="alert alert-warning" style='margin: 20px 0;'>
                          <?php echo $error; ?>
                      </div>
                  <?php endif ?>
                  <table style='margin-top:20px;' class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr id='th'>
                            <th> Control Identifier </th>
                            <th> Requester Name </th>
                            <th> Requisition Type </th>
                            <th> Status </th>
                            <th> Datetime Created </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if ($requisitions && 0 != $requisitions->num_rows) { ?>
                          <?php  while ($item = $requisitions->fetch_assoc()) { ?>

                            <?php
                                $stocksRepo = new Stocks();
                                $itemsInRequisition = $stocksRepo->getStockByRequisitionId($item['requisition_id']);
                                
                                $firstItem = '';

                                if ($itemsInRequisition) {
                                  $firstItem = $itemsInRequisition->fetch_assoc();
                                }

                                //--. Get Requisition Current Status .--//
                                $requisitionCurrentStatus = $requisitionsRepo->getCurrentRequisitionStatus($item['requisition_id']);
                            ?>
                            <tr data-id="<?php echo $item['requisition_id']; ?>" data-type='<?php echo Constant::REQUISITION_ITEM; ?>'>
                              <td><?php echo $item['requisition_control_identifier']; ?>
                              </td>
                              <td> <?php echo RequesterUtility::getFullName($item); ?></td>
                              <td> <?php echo $item['requisition_type']; ?></td>
                              <td>
                                  <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                              </td>
                              <td>
                                  <?php echo $item['requisition_datetime_added']; ?>
                              </td>
                              <td>
                                  <a class='btn btn-default' href="<?php echo Link::createUrl('Pages/Reports/IndividualReport.php?control_identifier='.$item['requisition_control_identifier']); ?>"> CREATE REPORT </a>
                              </td>
                            </tr>  
                          <?php } ?>
                      <?php } else { ?>
                            <tr>
                                <td colspan=6>
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
<?php Template::footer(['report.js']); ?>