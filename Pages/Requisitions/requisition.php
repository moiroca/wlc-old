<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

if (isset($_GET['control_identifier'])) { $controlIdentifier = $_GET['control_identifier']; } else { throw new Exception('Page Not Found'); }

$requisitionObj = new Requisitions();
$requisition = $requisitionObj->getRequisitionByControlIdentifier($controlIdentifier);

if ($requisition && 0 != $requisition->num_rows) {
    $requisition = $requisition->fetch_assoc();
}

//--. Get Requisition Current Status .--//
$requisitionCurrentStatus = $requisitionObj->getCurrentRequisitionStatus($requisition['requisition_id']);

$userObj = new User();
$stocksRepo = new Stocks();

if ($requisition['requisition_type'] == Constant::REQUISITION_JOB) {

    //-- For Pending 
    if ($requisitionCurrentStatus == Constant::REQUISITION_PENDING) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']);
    }

    //-- For Verified By GSD Officer
    if ($requisitionCurrentStatus == Constant::VERIFIED_BY_GSD_OFFICER) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']);
    }

    //-- For Declined By President and Declined By GSD Officer
    if ($requisitionCurrentStatus == Constant::DECLINED_BY_PRESIDENT || $requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']);
    }

    //-- For Verified By President
    if ($requisitionCurrentStatus == Constant::APPROVED_BY_PRESIDENT) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']);
    }

    //-- For Released By GSD Officer
    if ($requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER) {
        $itemsInRequisition = $stocksRepo->getAllApprovedStockByJobRequisitionId($requisition['requisition_id']);        
    }

    //-- For Received By Requester
    if ($requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER) {
        $itemsInRequisition = $stocksRepo->getAllApprovedAndReceivedStockByJobRequisitionId($requisition['requisition_id']);
    }
} else {

    //-- For Pending 
    if ($requisitionCurrentStatus == Constant::REQUISITION_PENDING) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeITEM($requisition['requisition_id']); 
    }

    //-- For Verified By GSD Officer
    if ($requisitionCurrentStatus == Constant::VERIFIED_BY_GSD_OFFICER || $requisitionCurrentStatus == Constant::VERIFIED_BY_PROPERTY_CUSTODIAN) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeITEM($requisition['requisition_id']);    
    }

    //-- For Approved By President
    if ($requisitionCurrentStatus == Constant::APPROVED_BY_PRESIDENT) {
        $itemsInRequisition = $stocksRepo->getAllApprovedAndAttachedItemInRequisition($requisition['requisition_id']);       
    }

    //-- Declined By President Or Declined By Property Custodian Or Declined BY GSD Officer
    if ($requisitionCurrentStatus == Constant::DECLINED_BY_PRESIDENT ||
        $requisitionCurrentStatus == Constant::DECLINED_BY_PROPERTY_CUSTODIAN ||
        $requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER) {
        $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeITEM($requisition['requisition_id']); 
    }

    //-- For Released By GSD Officer Or Released by Property Custodian
    if ($requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER || $requisitionCurrentStatus == Constant::RELEASED_BY_PROPERTY_CUSTODIAN) {
        $itemsInRequisition = $stocksRepo->getAllApprovedStockByItemRequisitionId($requisition['requisition_id']);         
    }

    //-- For Received By Requester
    if ($requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER) {
        $itemsInRequisition = $stocksRepo->getAllApprovedStockByItemRequisitionId($requisition['requisition_id']);         
    }
}

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
                  <i class="fa fa-table"></i>  <a href="#">Requisition</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-8">
    	<div class="panel panel-info">
    		<div class="panel-heading"> 
    			<label class="panel-title">Requisition Details</label>
    		</div>
    		<div class="panel-body" >
                    <input type='hidden' id='approval_item_requisition_link' value='<?php echo Link::createUrl('Controllers/ApproveRequisition.php'); ?>'>
                    <input type='hidden' value="<?php echo $requisition['requisition_id']; ?>" id="requisition_id">
                    <input type='hidden' value="<?php echo Link::createUrl('Controllers/approveItemInRequisition.php'); ?>" id="approve_item_in_requisition" />
                    
                    <?php if (isset($_GET['requisition']) && $_GET['requisition'] == 'Job'): ?>

                            <?php if ($requisitionCurrentStatus == Constant::REQUISITION_PENDING): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Jobs/pending_items.php' ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::DECLINED_BY_PRESIDENT || $requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Jobs/declined.php' ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::VERIFIED_BY_GSD_OFFICER): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Jobs/verified_by_gsd_officer_items.php' ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::APPROVED_BY_PRESIDENT): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Jobs/release_items.php' ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER): ?>                                
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Jobs/receiving_items.php' ?>
                            <?php else: ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Jobs/received_items.php' ?>
                            <?php endif ?>
                    <?php else: ?>
                            <?php if ($requisitionCurrentStatus == Constant::REQUISITION_PENDING): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/pending_items.php' ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::DECLINED_BY_PRESIDENT ||
                                            $requisitionCurrentStatus == Constant::DECLINED_BY_PROPERTY_CUSTODIAN ||
                                            $requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/pending_items.php' ?>
                            <?php elseif (in_array($requisitionCurrentStatus, [Constant::VERIFIED_BY_GSD_OFFICER, Constant::VERIFIED_BY_PROPERTY_CUSTODIAN])): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/verified_by_gsd_pc.php' ?>
                                
                                <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                    <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/items_in_stocks.php' ?>
                                    <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/items_for_approval.php' ?>
                                <?php endif ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::APPROVED_BY_PRESIDENT): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/approved_by_president.php' ?>
                            <?php elseif ($requisitionCurrentStatus == Constant::RELEASED_BY_PROPERTY_CUSTODIAN || $requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER): ?>
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/receiving_items.php' ?>
                            <?php else: ?>  
                                <?php include $_SERVER['DOCUMENT_ROOT'].'/Pages/Requisitions/Items/received_items.php' ?>
                            <?php endif ?>  
                    <?php endif ?>
                    <div id="comments_wrapper" data-requisition_id="<?php echo $requisition['requisition_id']; ?>">
                        <input type='hidden' id='add_requisition_comment' value='<?php echo Link::createUrl('Controllers/AddComment.php'); ?>'>
                        <?php
                            $requisitionCommentsRepo = new RequisitionComments();

                            $comments =  $requisitionCommentsRepo->getAllRequisitionCommentsByRequisitionId($requisition['requisition_id']);
                            
                        ?>
                        <h4>Requisition Comments</h4>
                        <div class="list-group">

                            <?php if ($comments && 0 != $comments->num_rows): ?>

                                <?php while($comment = $comments->fetch_assoc()): ?>
                                    <a href="javascript:void(0)" class="list-group-item">
                                        <h4 class="list-group-item-heading"><?php echo RequesterUtility::getFullName($comment); ?> <small><?php echo date_create($comment['comment_datetime_added'])->format('Y-m-d'); ?></small></h4>
                                        <p class="list-group-item-text"><?php echo $comment['requisition_comment']; ?></p>
                                    </a>
                                <?php endwhile; ?>
                                
                            <?php else: ?>
                                <a href="javascript:void(0)" class="list-group-item">
                                    <label class="label label-info"><i class="fa fa-info"></i>  There is no comment available.</label>
                                </a>
                            <?php endif ?>
                        </div>
                        <div class=''>
                            <?php if ($requisitionCurrentStatus != Constant::APPROVED_BY_PRESIDENT): ?>
                                <a href="javascript:void(0)" class="list-group-item">
                                    <textarea style='margin-bottom: 10px;' id="comment" class='form-control'></textarea>
                                    <button id='save-comment' type='button' class='form-control btn btn-primary'> Save Comment</button>
                                </a>    
                            <?php endif ?>
                        </div>
                    </div>
    		</div>
    	</div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading"> 
                <label class="panel-title">Requisition Signatures</label>
            </div>
            <div class="panel-body">
                    <div>
                        <p><b>Control Identifier: </b> <?php echo $requisition['requisition_control_identifier']; ?> </p>
                    </div>
                    <div>
                        <p><b>Purpose: </b> <?php echo $requisition['requisition_purpose']; ?></p>
                    </div>
                    <div>
                        <p><b>Area: </b> <?php echo $requisition['requisition_area_name']; ?></p>
                    </div>
                    <div>
                        <p>
                            <b>Datetime Requested: </b> 
                            <?php
                                $datetime = new Datetime($requisition['requisition_datetime_added']);
                                echo $datetime->format("Y-m-d H:i:s");
                            ?>
                        </p>
                    </div>
                    <div>
                        <p>
                            <b>Status: </b> 
                            <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                        </p>
                    </div>
                    <div> 
                        <b>Requester Details: </b> 
                        <ul style="list-style:none">
                            <li>
                                <p>
                                    <b>Name: </b> 
                                    <?php
                                        $user = $userObj->getAll(['*'], ['id' => $requisition['requisition_requester_id']])->fetch_assoc();
                                        echo $user['lastname'].', '.$user['firstname'];
                                    ?>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
                        
                        <!--GSD Officer -->
                        <div> 
                            <b>GSD Officer Details: </b> 
                            <?php
                                $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::VERIFIED_BY_GSD_OFFICER, Constant::DECLINED_BY_GSD_OFFICER], true);
                            ?>
                            <ul style="list-style:none">
                                <li>
                                    <p>
                                        <b>Name: </b> 
                                        <?php if ($actor) { ?>
                                            <?php echo RequesterUtility::getFullName($actor);  ?>
                                        <?php } else { ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php } ?>
                                    </p>
                                </li>

                                <?php if ($actor): ?>
                                    <li>
                                        <!-- <p>
                                            <b>Action: </b>
                                            <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                                        </p> -->
                                        <p>
                                            <b>Action Datetime:</b>
                                            <?php echo $actor['datetime_added']; ?>
                                        </p>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>   
                    <?php else: ?>
                        <?php if ($firstItem && $firstItem['stock_type'] == Constant::ITEM_MATERIAL_EQUIPMENT): ?>
                            
                            <!--GSD Officer -->
                            <div> 
                                <b>GSD Officer Details: </b> 
                                <?php
                                    $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::VERIFIED_BY_GSD_OFFICER, Constant::DECLINED_BY_GSD_OFFICER], true);
                                ?>
                                <ul style="list-style:none">
                                    <li>
                                        <p>
                                            <b>Name: </b> 
                                            <?php if ($actor) { ?>
                                                <?php echo RequesterUtility::getFullName($actor);  ?>
                                            <?php } else { ?>
                                                <label class='label label-info'>Not Available</label>
                                            <?php } ?>
                                        </p>
                                    </li>

                                    <?php if ($actor): ?>
                                        <li>
                                            <!-- <p>
                                                <b>Action: </b>
                                                <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                                            </p> -->
                                            <p>
                                                <b>Action Datetime:</b>
                                                <?php echo $actor['datetime_added']; ?>
                                            </p>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </div>    
                        <?php else: ?>
                            <div> 
                                <b>Property Custodian Details: </b> 
                                <?php
                                    $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::VERIFIED_BY_PROPERTY_CUSTODIAN, Constant::DECLINED_BY_PROPERTY_CUSTODIAN], true);
                                ?>
                                <ul style="list-style:none">
                                    <li>
                                        <p>
                                            <b>Name: </b> 
                                            <?php if ($actor) { ?>
                                                <?php echo RequesterUtility::getFullName($actor);  ?>
                                            <?php } else { ?>
                                                <label class='label label-info'>Not Available</label>
                                            <?php } ?>
                                        </p>
                                    </li>

                                    <?php if ($actor): ?>
                                        <li>
                                            <!-- <p>
                                                <b>Action: </b>
                                                <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                                            </p> -->
                                            <p>
                                                <b>Action Datetime:</b>
                                                <?php echo $actor['datetime_added']; ?>
                                            </p>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        <?php endif ?>
                        <!--. Remain Comment -->
                        <!-- 
                        <div> 
                            <b>Comptroller Details: </b> 
                            <?php
                                $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::APPROVED_BY_COMPTROLLER, Constant::DECLINED_BY_COMPTROLLER], true);
                            ?>
                            <ul style="list-style:none">
                                <li>
                                    <p>
                                        <b>Name: </b> 
                                        <?php if ($actor) { ?>
                                            <?php echo RequesterUtility::getFullName($actor);  ?>
                                        <?php } else { ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php } ?>
                                    </p>
                                </li>

                                <?php if ($actor): ?>
                                    <li>
                                        <p>
                                            <b>Action: </b>
                                            <?php echo $actor['status']; ?>
                                        </p>
                                        <p>
                                            <b>Action Datetime:</b>
                                            <?php echo $actor['datetime_added']; ?>
                                        </p>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div> -->
                    <?php endif ?>
                    <div> 
                        <b>President Details: </b> 
                        <?php
                            $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::APPROVED_BY_PRESIDENT, Constant::DECLINED_BY_PRESIDENT], true);
                        ?>
                        <ul style="list-style:none">
                            <li>
                                <p>
                                    <b>Name: </b> 
                                    <?php if ($actor) { ?>
                                        <?php echo RequesterUtility::getFullName($actor);  ?>
                                    <?php } else { ?>
                                        <label class='label label-info'>Not Available</label>
                                    <?php } ?>
                                </p>
                            </li>

                            <?php if ($actor): ?>
                                <li>
                                    <!-- <p>
                                        <b>Action: </b>
                                        <?php echo RequisitionDecorator::status($requisitionCurrentStatus) ;?>
                                    </p> -->
                                    <p>
                                        <b>Action Datetime:</b>
                                        <?php echo $actor['datetime_added']; ?>
                                    </p>
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>