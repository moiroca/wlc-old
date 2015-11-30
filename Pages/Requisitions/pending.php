<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$requisitions = new Requisitions();

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
            if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) {
                $result = $requisitions->getAllRequesitionForApprovalByPresident(Constant::REQUISITION_ITEM);  
            } else {
                $result = $requisitions->getAllRequesition(Constant::REQUISITION_ITEM);
            }
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
        <table class="table table-striped table-hover table-bordered">
          <thead>
              <tr id='th'>
                <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                  <th> View Items </th>
                  <th> Control Identifier </th>
                  <th> Approved By </th>
                  <th> Purpose </th>
                  <th> Requisition Type </th>
                  <th> Action </th>
                <?php else: ?>
                  <th> View Items </th>
                  <th> Control Identifier </th>
                  <th> Requester Name </th>
                  <th> Purpose </th>

                  <th> Status </th>
                  <th> Action </th>
                <?php endif ?>
              </tr>
          </thead>
          <tbody>
            <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
              <input type="hidden" id="approve_item_requisition_url" value="<?php echo Link::createUrl('Controllers/ApproveRequisitionByPresident.php'); ?>" />
              <input type="hidden" id="declined_item_requisition_url" value="<?php echo Link::createUrl('Controllers/DeclinedRequisitionByPresident.php'); ?>" />
              <input type="hidden" id="requisition_type" value="<?php echo Constant::REQUISITION_ITEM; ?>"/>
              <?php if ($result && 0 != $result->num_rows) { ?>
                  <?php  while ($item = $result->fetch_assoc()) { ?>
                    <tr data-requesterId="<?php echo $item['requisition_requester_id']; ?>"  data-id="<?php echo $item['requisition_id']; ?>" data-type='<?php echo Constant::REQUISITION_ITEM; ?>'>
                      <td> 
                        <?php if ($item['requisition_status'] == Constant::REQUISITION_APPROVED ) { ?>
                          <a 
                            class='btn btn-success btn-sm' 
                            href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php?control_identifier='.$item['requisition_control_identifier']); ?>">
                            <i class='fa fa-table'></i> View Items
                          </a> 
                        <?php } else { ?> 
                          <i class='label label-info'>Items Not Available</i> 
                        <?php } ?>
                      </td>
                      <td> 
                          <a title="View Details Of Requisition" href="#"><?php echo $item['requisition_control_identifier']; ?></a>
                      </td>
                      <td> <?php echo '<b>'.$item['approver_type'].'</b>'.': '.RequesterUtility::getFullName($item); ?></td>
                      <td> <?php echo $item['requisition_purpose']; ?></td>
                      <td> <?php echo $item['requisition_type']; ?> </td>
                      <!-- <td> <?php $date = new DateTime($item['requisition_datetime_added']);
                      echo $date->format('Y-m-d H:i:s'); ?></td> -->
                      <!-- <td>
                          <?php if ($item['requisition_datetime_provided']) { ?>
                              <?php echo $item['requisition_datetime_provided']; ?>
                          <?php } else { ?>
                              <i class='label label-info'>Datetime not available</i>
                          <?php } ?>
                      </td> -->
                      <td>
                          <?php if ($item['requisition_status'] != Constant::REQUISITION_APPROVED) { ?> 
                            <a href="javascript:void(0)" class='btn btn-large btn-primary approve_item_by_president_btn'> <i class='fa fa-thumbs-up'></i> Approve</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          <?php } ?>
                          <!-- <a href="#" class='btn btn-sm btn-default'> <i class='fa fa-edit'></i> Edit</a>
                          <a href="#" class='btn btn-sm btn-warning'> <i class='fa fa-edit'></i> Delete</a> -->
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
            <?php else: ?>
              <?php if ($result && 0 != $result->num_rows) { ?>
                  <?php  while ($item = $result->fetch_assoc()) { ?>
                    <tr data-id="<?php echo $item['requisition_id']; ?>" data-type='<?php echo Constant::REQUISITION_ITEM; ?>'>
                      <td> 
                        <?php if ($item['requisition_status'] == Constant::REQUISITION_APPROVED ) { ?>
                          <a 
                            class='btn btn-success btn-sm' 
                            href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php?control_identifier='.$item['requisition_control_identifier']); ?>">
                            <i class='fa fa-table'></i> View Items
                          </a> 
                        <?php } else { ?> 
                          <i class='label label-info'>Items Not Available</i> 
                        <?php } ?>
                      </td>
                      <td> 
                          <a title="View Details Of Requisition" href="#"><?php echo $item['requisition_control_identifier']; ?></a>
                      </td>
                      <td> <?php echo RequesterUtility::getFullName($item); ?></td>
                      <td> <?php echo $item['requisition_purpose']; ?></td>
                      <!-- <td> <?php $date = new DateTime($item['requisition_datetime_added']);
                      echo $date->format('Y-m-d H:i:s'); ?></td> -->
                      <!-- <td>
                          <?php if ($item['requisition_datetime_provided']) { ?>
                              <?php echo $item['requisition_datetime_provided']; ?>
                          <?php } else { ?>
                              <i class='label label-info'>Datetime not available</i>
                          <?php } ?>
                      </td> -->
                      <td> 
                        <?php if ($item['requisition_status'] == Constant::REQUISITION_APPROVED) { ?> 
                          <i class='label label-success'><?php echo $item['requisition_status']; ?></i>
                        <?php } else { ?> 
                          <i class='label label-info'><?php echo $item['requisition_status']; ?></i>
                        <?php } ?>
                      </td>
                      <td>
                          <?php if ($item['requisition_status'] != Constant::REQUISITION_APPROVED) { ?> 
                            <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/approve.php?control_identifier='.$item['requisition_control_identifier']); ?>" class='btn btn-large btn-primary'> <i class='fa fa-thumbs-up'></i> Approve</a>
                          <?php } ?>
                          <?php if ($item['requisition_status'] != Constant::REQUISITION_APPROVED) { ?> 
                            <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/approve.php?control_identifier='.$item['requisition_control_identifier']); ?>" class='btn btn-sm btn-warning'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          <?php } ?>
                          <!-- <a href="#" class='btn btn-sm btn-default'> <i class='fa fa-edit'></i> Edit</a>
                          <a href="#" class='btn btn-sm btn-warning'> <i class='fa fa-edit'></i> Delete</a> -->
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
            <?php endif ?>
          </tbody>
        </table>
        <span>
            <input type='hidden' id='approval_item_requisition_link' value='<?php echo Link::createUrl('Controllers/ApproveRequisition.php'); ?>'>
        </span>
      </div>
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>