<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$requisitions = new Requisitions();
$userObj = new User();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

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
                  <i class="fa fa-table"></i>  <a href="#">Item Requisition</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <?php 
            $result = $requisitions->getRequisitionByUserType(Login::getUserLoggedInType(), Constant::REQUISITION_JOB);
        ?>
        <?php if (isset($_SESSION['record_successful_added'])) { ?>
        <?php unset($_SESSION['record_successful_added']); ?>
            <div class="alert alert-success">
                Item Requisition Record Succesfully Added.
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['something_wrong'])) { ?>
        <?php unset($_SESSION['something_wrong']); ?>
            <div class="alert alert-danger">
                The System is still in development mode. Expect more bugs to come. 
            </div>
        <?php } ?>
        <span>
            <input type="hidden" id="requisition_type" value="<?php echo Constant::REQUISITION_JOB; ?>"/>
        </span>
        <table class="table table-striped table-hover table-bordered">
          <thead>
              <tr id='th'>
                  <th> Control Identifier </th>
                  <th> Requester Name </th>
                  <th> Department Head Details </th>
                  <th> GSD Officer Details</th>
                  <th> Treasurer Details</th>
                  <th> President Details</th>
                  <th> Status </th>
                  <?php if (UserUtility::isApprover(Login::getUserLoggedInType())): ?>
                      <th> Action </th>
                  <?php endif ?>
              </tr>
          </thead>
          <tbody>
            <input type="hidden" id="declined_item_requisition_url" value="<?php echo Link::createUrl('Controllers/DeclineRequisition.php'); ?>" />
            <input type="hidden" id="approve_item_requisition_url" value="<?php echo Link::createUrl('Controllers/ApproveRequisitionByPresident.php'); ?>" />
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <?php
                      $stocksRepo = new Stocks();
                      $itemsInRequisition = $stocksRepo->getStockByRequisitionId($item['requisition_id']);
                      $firstItem = $itemsInRequisition->fetch_assoc();

                      //--. Get Requisition Current Status .--//
                      $requisitionCurrentStatus = $requisitions->getCurrentRequisitionStatus($item['requisition_id']);
                  ?>
                  <tr data-id="<?php echo $item['requisition_id']; ?>" data-type='<?php echo Constant::REQUISITION_ITEM; ?>'>
                    <td> 
                        <a title="View Details Of Requisition" href="<?php echo Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$item['requisition_control_identifier']); ?>"><?php echo $item['requisition_control_identifier']; ?></a>
                    </td>
                    <td> <?php echo RequesterUtility::getFullName($item); ?></td>
                    <td>
                        <?php
                            $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::NOTED_BY_DEPARTMENT_HEAD, Constant::DECLINED_BY_DEPARTMENT_HEAD], true);
                        ?>
                        <?php if ($actor) { ?>
                              <?php echo RequesterUtility::getFullName($actor);  ?>
                        <?php } else { ?>
                            <label class='label label-info'>Not Available</label>
                        <?php } ?>
                    </td>
                    <td>
                        <?php 
                              $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::VERIFIED_BY_GSD_OFFICER, Constant::DECLINED_BY_GSD_OFFICER], true);
                        ?> 
                        <?php if ($actor) { ?>
                              <?php echo RequesterUtility::getFullName($actor);  ?>
                        <?php } else { ?>
                            <label class='label label-info'>Not Available</label>
                        <?php } ?>
                    </td>
                    <td>
                        <?php 
                              $actor = $requisitions->getRequisitionActorByStatus($item['requisition_id'], [Constant::APPROVED_BY_TREASURER, Constant::DECLINED_BY_TREASURER], true);
                        ?>
                        <?php if ($actor) { ?>
                            <?php echo RequesterUtility::getFullName($actor); ?>
                        <?php } else { ?>
                            <label class='label label-info'>Not Available</label>
                        <?php } ?>
                    </td>
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
                        <label class='label label-info'>
                          <?php if ($requisitionCurrentStatus): ?>
                              <?php echo $requisitionCurrentStatus; ?>
                          <?php else: ?>
                              <i class="fa fa-info"></i> Pending for Approval
                          <?php endif ?>
                        </label>
                    </td>
                    <?php if (Login::getUserLoggedInType() == Constant::USER_DEPARTMENT_HEAD): ?>
                        <td> 
                          <?php if (!RequisitionUtility::isRequisitionActionedByDepartmentHead($item['requisition_status'])): ?>
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Note</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          <?php else: ?>
                            <label class="label label-info">No Actions Found</label>
                          <?php endif ?>
                        </td>
                    <?php elseif (Login::getUserLoggedInType() == Constant::USER_PROPERTY_CUSTODIAN || Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER): ?>
                        <td> 
                          <?php if (!RequisitionUtility::isRequisitionActionedByPropertyCustodianOrGSDOfficer($item['requisition_status'])): ?>
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Verify</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          <?php else: ?>
                            <label class="label label-info">No Actions Found</label>
                          <?php endif ?>
                        </td>
                    <?php elseif (Login::getUserLoggedInType() == Constant::USER_COMPTROLLER): ?>
                        <td> 
                          <?php if (!RequisitionUtility::isRequisitionActionedByComptroller($item['requisition_status'])): ?>
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Approve</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          <?php else: ?>
                            <label class="label label-info">No Actions Found</label>
                          <?php endif ?>
                        </td>
                    <?php elseif (Login::getUserLoggedInType() == Constant::USER_TREASURER): ?>
                        <td>
                            <?php if (!RequisitionUtility::isRequisitionActionedByTreasurer($item['requisition_status'])): ?>
                              <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Approve</a>
                              <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                            <?php else: ?>
                              <label class="label label-info">No Actions Found</label>
                            <?php endif; ?>
                        </td>
                    <?php elseif (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                      <td> 
                          <?php if (!RequisitionUtility::isRequisitionActionedByPresident($item['requisition_status'])): ?>
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Approve</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          <?php else: ?>
                            <label class="label label-info">No Actions Found</label>
                          <?php endif; ?>
                      </td>
                    <?php endif ?>
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
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>