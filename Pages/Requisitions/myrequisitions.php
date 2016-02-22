<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$requisitions = new Requisitions();
$userRequisition = $requisitions->getRequisitionByUserType(null, null, Login::getUserLoggedInId());

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Requisitions</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Requisitions</a>
              </li>
              <li class='active'>
                  <i class="fa fa-table"></i>  <a href="#">My Requisition</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">My Requisitions</div>
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
                            <th> Requisition Type </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if ($userRequisition && 0 != $userRequisition->num_rows) { ?>
                          <?php  while ($item = $userRequisition->fetch_assoc()) { ?>

                            <?php
                                $stocksRepo = new Stocks();
                                $itemsInRequisition = $stocksRepo->getStockByRequisitionId($item['requisition_id']);
                                
                                $requisitionCurrentStatus = $requisitions->getCurrentRequisitionStatus($item['requisition_id']);
                                $firstItem = '';

                                if ($itemsInRequisition) {
                                  $firstItem = $itemsInRequisition->fetch_assoc();
                                }

                            ?>
                            <tr data-id="<?php echo $item['requisition_id']; ?>" data-type='<?php echo Constant::REQUISITION_ITEM; ?>'>
                              <td> 
                                  <a title="View Details Of Requisition" href="<?php echo Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$item['requisition_control_identifier'].'&requisition='.$item['requisition_type']); ?>"><?php echo $item['requisition_control_identifier']; ?></a>
                              </td>
                              <td> <?php echo $item['requisition_type']; ?></td>
                              <td>
                                  <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                              </td>

                              <td>
                                  <?php if ($item['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                      <?php if ($requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER || $requisitionCurrentStatus == Constant::RELEASED_BY_PROPERTY_CUSTODIAN): ?>
                                          <button class='btn btn-default btn-lg approve_item_requisition'>Receive</button>
                                      <?php elseif($requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER) : ?>
                                          <label class='label label-info'>Received By Requester</label>
                                      <?php else: ?>
                                          <label class='label label-info'>Receive Not Yet Available</label>
                                      <?php endif ?>
                                  <?php else: ?>
                                      <?php if ($requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER || $requisitionCurrentStatus == Constant::RELEASED_BY_PROPERTY_CUSTODIAN): ?>
                                          <button class='btn btn-default btn-lg approve_item_requisition'>Receive</button>
                                      <?php elseif($requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER) : ?>
                                          <label class='label label-info'>Received By Requester</label>
                                      <?php else: ?>
                                          <label class='label label-info'>Receive Not Yet Available</label>
                                    <?php endif ?>
                                  <?php endif ?>
                              </td>  
                              
                            </tr>  
                          <?php } ?>
                      <?php } else { ?>
                            <tr>
                                <td colspan=8>
                                    <div class="alert alert-info">
                                        There are no items found.
                                    </div>
                                </td>
                            </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <span>
                      <input type='hidden' id='approval_item_requisition_link' value='<?php echo Link::createUrl('Controllers/ApproveRequisition.php'); ?>'>
                  </span>
                </div>
            </div>
        </div>
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>