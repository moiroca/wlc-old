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
                  <th> ITEMS </th>
                  <th> CONTROL IDENTIFIER </th>
                  <th> REQUESTER NAME </th>
                  <th> STATUS </th>
                  <?php if (UserUtility::isApprover(Login::getUserLoggedInType())): ?>
                      <th> Action </th>
                  <?php endif ?>
              </tr>
          </thead>
          <tbody>
            <input type="hidden" id="approve_item_requisition_url" value="<?php echo Link::createUrl('Controllers/ApproveRequisitionByPresident.php'); ?>" />
            <input type="hidden" id="declined_item_requisition_url" value="<?php echo Link::createUrl('Controllers/DeclineRequisition.php'); ?>" />
            <input type="hidden" id="requisition_type" value="<?php echo Constant::REQUISITION_ITEM; ?>"/>
            
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
                      <td> 
                        <?php if ($item['requisition_status'] == Constant::REQUISITION_APPROVED) { ?> 
                          <i class='label label-success'><?php echo $item['requisition_status']; ?></i>
                        <?php } else { ?> 
                          <i class='label label-info'><?php echo $item['requisition_status']; ?></i>
                        <?php } ?>
                      </td>
                      <?php if (Login::getUserLoggedInType() == Constant::USER_DEPARTMENT_HEAD): ?>
                          <td> 
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Note</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          </td>
                      <?php elseif (Login::getUserLoggedInType() == Constant::USER_PROPERTY_CUSTODIAN || Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER): ?>
                          <td> 
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Note</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          </td>
                      <?php elseif (Login::getUserLoggedInType() == Constant::USER_COMPTROLLER): ?>
                          <td> 
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Approve</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                          </td>
                      <?php elseif (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                        <td> 
                            <a style='margin-bottom: 5px;' href="javascript:void(0)" class='btn btn-large btn-primary approve_item_requisition'> <i class='fa fa-thumbs-up'></i> Approve</a>
                            <a href="javascript:void(0)" class='btn btn-sm btn-warning decline_requisition'> <i class='fa fa-thumbs-down'></i> Decline</a>
                        </td>
                      <?php endif ?>
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
        <span>
            <input type='hidden' id='approval_item_requisition_link' value='<?php echo Link::createUrl('Controllers/ApproveRequisition.php'); ?>'>
        </span>
      </div>
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>