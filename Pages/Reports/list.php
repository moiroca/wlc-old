<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$requisitionsRepo = new Requisitions();
$requisitions = $requisitionsRepo->getAllRequesition();

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
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr id='th'>
                            <th> Control Identifier </th>
                            <th> Requester Name </th>
                            <th> Requisition Type </th>
                            <th> Status </th>
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
                                  <a class='btn btn-default' href="<?php echo Link::createUrl('Pages/Reports/IndividualReport.php?control_identifier='.$item['requisition_control_identifier']); ?>"> CREATE REPORT </a>
                              </td>
                            </tr>  
                          <?php } ?>
                      <?php } else { ?>
                            <tr>
                                <td colspan=5>
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
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>