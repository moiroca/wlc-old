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
                            <th> Requester Name </th>
                            <th> Requisition Type </th>
                            <!-- <th> Department Head Details</th> -->
                            <th> <?php echo Constant::USER_PROPERTY_CUSTODIAN.'/ '.Constant::USER_GSD_OFFICER; ?></th>
                            <!-- <th> Approved By Comptroller </th> -->
                            <th> Approved By President </th>
                            <th> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                      <input type="hidden" id="declined_item_requisition_url" value="<?php echo Link::createUrl('Controllers/DeclineRequisition.php'); ?>" />
                      <input type="hidden" id="approve_item_requisition_url" value="<?php echo Link::createUrl('Controllers/ApproveRequisitionByPresident.php'); ?>" />
                      <?php if ($userRequisition && 0 != $userRequisition->num_rows) { ?>
                          <?php  while ($item = $userRequisition->fetch_assoc()) { ?>

                            <?php
                                $stocksRepo = new Stocks();
                                $itemsInRequisition = $stocksRepo->getStockByRequisitionId($item['requisition_id']);
                                
                                $firstItem = '';

                                if ($itemsInRequisition) {
                                  $firstItem = $itemsInRequisition->fetch_assoc();
                                }

                                //--. Get Requisition Current Status .--//
                                $requisitionCurrentStatus = $requisitions->getCurrentRequisitionStatus($item['requisition_id']);
                            ?>
                            <tr data-id="<?php echo $item['requisition_id']; ?>" data-type='<?php echo Constant::REQUISITION_ITEM; ?>'>
                              <td> 
                                  <a title="View Details Of Requisition" href="<?php echo Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$item['requisition_control_identifier']); ?>"><?php echo $item['requisition_control_identifier']; ?></a>
                              </td>
                              <td> <?php echo RequesterUtility::getFullName($item); ?></td>
                              <td> <?php echo $item['requisition_type']; ?></td>
                              <!-- <td>
                                  <?php
                                      $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::NOTED_BY_DEPARTMENT_HEAD, Constant::DECLINED_BY_DEPARTMENT_HEAD], true);
                                  ?>
                                  <?php if ($actor) { ?>
                                        <?php echo RequesterUtility::getFullName($actor);  ?>
                                  <?php } else { ?>
                                      <label class='label label-info'>Not Available</label>
                                  <?php } ?>
                              </td> -->
                              <td>

                                  <?php if ($firstItem && $firstItem['stock_type'] == Constant::ITEM_MATERIAL_EQUIPMENT): ?>
                                        <?php 
                                              $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::VERIFIED_BY_GSD_OFFICER, Constant::DECLINED_BY_GSD_OFFICER], true);
                                        ?> 
                                        <?php if ($actor) { ?>
                                              <b>GSD OFFICER: </b><?php echo RequesterUtility::getFullName($actor);  ?>
                                        <?php } else { ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php } ?>
                                  <?php else: ?>
                                        <?php 
                                              $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::VERIFIED_BY_PROPERTY_CUSTODIAN, Constant::DECLINED_BY_PROPERTY_CUSTODIAN], true);
                                        ?> 
                                        <?php if ($actor) { ?>
                                              <b>PROPERTY CUSTODIAN: </b><?php echo RequesterUtility::getFullName($actor);  ?>
                                        <?php } else { ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php } ?>
                                  <?php endif ?>
                              </td>
                              <!-- <td>
                                  <?php 
                                        $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::APPROVED_BY_COMPTROLLER, Constant::DECLINED_BY_COMPTROLLER], true);
                                  ?>
                                  <?php if ($actor) { ?>
                                      <?php echo RequesterUtility::getFullName($actor); ?>
                                  <?php } else { ?>
                                      <label class='label label-info'>Not Available</label>
                                  <?php } ?>
                              </td> -->
                              <td>
                                  <?php 
                                        $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::APPROVED_BY_PRESIDENT, Constant::DECLINED_BY_PRESIDENT], true);
                                  ?>
                                  <?php if ($actor) { ?>
                                      <?php echo RequesterUtility::getFullName($actor); ?>
                                  <?php } else { ?>
                                      <label class='label label-info'>Not Available</label>
                                  <?php } ?>
                              </td>
                              <td>
                                  <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
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