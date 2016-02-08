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
    $itemsInRequisition = $stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']);
} else {

    if ($requisitionCurrentStatus == Constant::ITEM_VERIFIED_BY_PRESIDENT || 
        $requisitionCurrentStatus == Constant::RELEASED_BY_PROPERTY_CUSTODIAN || 
        $requisitionCurrentStatus == Constant::RELEASED_BY_GSD_OFFICER || 
        $requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER) {
        $itemsInRequisition = $stocksRepo->getApprovedItemInRequisition($requisition['requisition_id']);
    } else {
        $itemsInRequisition = $stocksRepo->getStockByRequisitionId($requisition['requisition_id'], true);
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
                    
                    <?php if ($requisitionCurrentStatus != Constant::ITEM_VERIFIED_BY_PRESIDENT && 
                              $requisitionCurrentStatus != Constant::RELEASED_BY_PROPERTY_CUSTODIAN && 
                              $requisitionCurrentStatus != Constant::RELEASED_BY_GSD_OFFICER &&
                              $requisitionCurrentStatus != Constant::RECEIVED_BY_REQUESTER): ?>
                        <table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
                                <thead>
                                    <tr>
                                        <th colspan="<?php echo (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) ? 7 : 6; ?>"> ITEMS IN REQUISITION </th>
                                    </tr>
                                    <tr>
                                        <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                            <th>Approved Quantity</th>
                                        <?php endif ?>
                                        <th>Name</th>
                                        <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                            <th>Quantity</th>
                                        <?php endif ?>
                                        <th>Price (in PHP)</th>
                                        <th>Unit</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody id="tempItemsForApproval">
                                    <?php 
                                        $firstItem = ''; 
                                        $stockNames = [];
                                        $itemsToApprove = [];
                                    ?>
                                    <?php if ($itemsInRequisition && 0 != $itemsInRequisition->num_rows): ?>
                                        <?php $total = 0; $index = 0; ?>

                                        <?php while($item = $itemsInRequisition->fetch_assoc()) { ?>
                                            <?php if (0 == $index): ?>
                                                <?php $firstItem = $item; ?>
                                            <?php endif ?>
                                            <tr data-original_stock_count="<?php echo $item['count_stocks'] ?>" data-count_stocks="<?php echo $item['count_stocks']; ?>" data-key="<?php echo $item['stock_name']; ?>" data-id="<?php echo $item['stock_id'] ?>" />
                                                <?php $itemsToApprove[] = $item; ?>
                                                <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                                    <!-- <td>
                                                        <input class='form-control input-sm approve-item' type='number' min=0 max="<?php echo $item['count_stocks'] ?>" value="<?php echo $item['count_stocks'] ?>">
                                                    </td> -->
                                                    <td>
                                                        <button type='button' style='display:none' class="btn-primary btn-sm btn plus-item-requisition"><i class='fa fa-plus'></i></button> 
                                                        <button type='button' class="btn-warning btn-sm btn minus-item-requisition"><i class='fa fa-minus '></i></button>
                                                    </td>
                                                <?php endif ?>
                                                <td><?php echo $item['stock_name'] ?></td>
                                                <?php $stockNames[] = $item['stock_name']; ?>

                                                <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                                    <td  class='count-stocks'>
                                                        <?php if ($requisitionCurrentStatus != Constant::APPROVED_BY_PRESIDENT && Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                                            <?php echo $item['count_stocks'] ?>
                                                        <?php else: ?>
                                                            <?php echo $item['count_stocks'] ?>
                                                        <?php endif ?>
                                                    </td>
                                                <?php endif ?>
                                                <td><?php echo $item['stock_price'] ?></td>
                                                <td><?php echo strtoupper($item['stock_unit']); ?></td>
                                                <td><?php echo $item['stock_type'] ?></td>
                                                <?php $total += $item['total_stock_price']; ?>
                                            </tr>
                                            <?php $index++; ?>
                                        <?php } ?>
                                            <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                                <tr>
                                                    <td colspan="<?php echo (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) ? 3 : 2; ?>"> <span class='pull-right'><b>TOTAL</b></span></td>
                                                    <td colspan="4"><span class='pull-left'>PHP <?php echo $total; ?></span></td>
                                                </tr>
                                            <?php endif ?>
                                    <?php else: ?>
                                            <tr>
                                                <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                                            </tr>
                                    <?php endif ?>
                                </tbody>
                        </table>

                        <!--. Items in Stocks Table .-->
                        <?php if ($requisitionCurrentStatus != Constant::APPROVED_BY_PRESIDENT && Login::getUserLoggedInType() == Constant::USER_PRESIDENT && $requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th colspan=7>ITEMS IN STOCKS</th>
                                    </tr>
                                    <tr>
                                        <td> Attach Item to Requisition </td>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody id="ItemInStock">
                                    <?php $emptySearch = 0; ?>
                                    <?php if ($stockNames): ?>

                                            <?php foreach ($stockNames as $key => $stockName): ?>
                                                    <?php
                                                        $searchItems = $stocksRepo->getStockByRequisitionId($requisition['requisition_id'], true, $stockName);

                                                        if ($searchItems->num_rows == 0) {  $emptySearch += 1; }
                                                    ?>
                                                    <?php while($searchItems && $item = $searchItems->fetch_assoc()) { ?>
                                                        <?php if (0 == $index): ?>
                                                            <?php $firstItem = $item; ?>
                                                        <?php endif ?>
                                                        <tr data-original_stock_count="<?php echo $item['count_stocks'] ?>"  data-count_stocks="<?php echo $item['count_stocks']; ?>"  data-key="<?php echo $item['stock_name']; ?>" data-id="<?php echo $item['stock_id'] ?>" />
                                                            <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                                                <!-- <td>
                                                                    <input class='form-control input-sm approve-item' type='number' min=1 max=<?php echo $item['count_stocks'] ?> value="<?php echo $item['count_stocks'] ?>">
                                                                </td> -->
                                                                <td>
                                                                    <button type='button' class="btn-primary btn-sm btn plus-item-stocks"><i class='fa fa-plus'></i></button> 
                                                                    <button type='button' class="btn-warning btn-sm btn minus-item-stocks"><i class='fa fa-minus'></i></button>
                                                                </td>
                                                                <!-- <td>
                                                                    <input type='checkbox' class='check-box' <?php echo ($item['stock_isRequest'] == 'FALSE') ? "checked" : ""; ?> />
                                                                </td> -->
                                                            <?php endif ?>
                                                            <td><?php echo $item['stock_name'] ?></td>
                                                            <td class='count-stocks'>
                                                                <?php echo $item['count_stocks'] ?>
                                                            </td>
                                                            <td><?php echo strtoupper($item['stock_unit']); ?></td>
                                                            <td><?php echo $item['stock_type'] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                            <?php endforeach ?>
                                    <?php endif ?>

                                    <?php if($emptySearch == sizeof($stockNames)) : ?>
                                        <tr class='info'>
                                            <td colspan=5 > No Same Items Found In Stocks </td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        <?php endif ?>

                        <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th colspan=7>Items to Approve</th>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <th>From Item Requisition</th>
                                        <th>From Item Stocks</th>
                                        <th>Total Quantity</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody id='itemsForApproval'>

                                    <?php if ($itemsToApprove): ?>
                                        <?php foreach ($itemsToApprove as $key => $item): ?>
                                            <tr data-key="<?php echo $item['stock_name'] ?>" data-count_stocks="<?php echo $item['count_stocks'] ?>">
                                                <td><?php echo $item['stock_name'] ?></td>
                                                <td class='from-item-requisition'><?php echo $item['count_stocks'] ?></td>
                                                <td class='from-item-stocks'>0</td>
                                                <td class='count-stocks'><?php echo $item['count_stocks'] ?></td>
                                                <td><?php echo $item['stock_unit']; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr class='info'>
                                            <td colspan=8 > No Item to Approve </td>
                                        </tr>    
                                    <?php endif ?>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan=8> <button type='button' id='approveRequisitionButton' class="btn btn-lg btn-primary"> Approve Item(s) In Requisition </button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php endif; ?>

                    <?php else: ?>
                        <?php 
                            $isLoggedInOwner = (Login::getUserLoggedInId() == $requisition['requisition_requester_id']);
                        ?>
                        <?php if ($isLoggedInOwner): ?>
                            <div class='alert alert-info'>
                                <i class='fa fa-info'></i> Click Checkbox to Mark as Received
                            </div>
                        <?php endif ?>
                        <table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
                                <thead>
                                    <tr>
                                        <th colspan="<?php echo ($isLoggedInOwner) ? 6 : 5; ?>"> 
                                            <p class='pull-left' style=';'>Approved ITEMS IN REQUISITION</p> 
                                            <?php if ($isLoggedInOwner): ?>
                                                <button class='btn btn-primary pull-right' type='button' id='receivedBtn'>Receive</button>
                                            <?php endif ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <?php if ($isLoggedInOwner): ?>
                                            <th> <input type='checkbox' id='checkAllItem' name=[]></th>
                                        <?php endif ?>
                                        <th>Name</th>
                                        <th>Price (in PHP)</th>
                                        <th>Type</th>
                                        <th>Area</th>
                                        <?php if ($isLoggedInOwner): ?>
                                            <th>Status</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tbody id="tempItemsForApproval">
                                    <?php 
                                        $firstItem = ''; 
                                        $stockNames = [];
                                        $itemsToApprove = [];
                                    ?>
                                    <?php if ($itemsInRequisition && 0 != $itemsInRequisition->num_rows): ?>
                                        <?php $total = 0; $index = 0; ?>

                                        <?php while($item = $itemsInRequisition->fetch_assoc()) { ?>
                                            <?php if (0 == $index): ?>
                                                <?php $firstItem = $item; ?>
                                            <?php endif ?>
                                            <tr data-id='<?php echo $item['stock_id']; ?>'>
                                                <?php $itemsToApprove[] = $item; ?>
                                                <?php if ($isLoggedInOwner): ?>
                                                    <td><input <?php echo ($item['stock_requisition_status'] == Constant::STOCK_RECEIVED) ? 'checked="checked"' : ''; ?> class='stock' type='checkbox' name="ids[]" value='<?php echo $item['stock_id']; ?>'></td>
                                                <?php endif ?>
                                                <td><?php echo $item['stock_name'] ?></td>
                                                <td><?php echo $item['stock_price'] ?></td>
                                                <?php $total += $item['stock_price']; ?>
                                                <td><?php echo $item['stock_type'] ?></td>
                                                <td><?php echo $item['area_name']; ?></td>
                                                <td class='status'>
                                                    <?php if ($item['stock_requisition_status'] == Constant::STOCK_APPROVED): ?>
                                                        <label class="label label-info"><?php echo $item['stock_requisition_status']; ?></label>    
                                                    <?php else: ?>
                                                        <label class="label label-success"><?php echo $item['stock_requisition_status']; ?></label>    
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                            <?php $index++; ?>
                                        <?php } ?>
                                            <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                                <tr>
                                                    <td > <span class='pull-right'><b>TOTAL</b></span></td>
                                                    <td colspan="<?php echo ($isLoggedInOwner) ? 5 : 4; ?>"><span class='pull-left'><?php echo $total; ?> PHP</span></td>
                                                </tr>
                                            <?php endif ?>
                                    <?php else: ?>
                                            <tr>
                                                <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                                            </tr>
                                    <?php endif ?>
                                </tbody>
                        </table>
                    <?php endif; ?>                    
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

                    <!--Department Head Details -->
                    <!-- <div> 
                        <b> Department Head Details: </b> 
                        <?php
                            $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::NOTED_BY_DEPARTMENT_HEAD, Constant::DECLINED_BY_DEPARTMENT_HEAD], true);
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

                        <!--TREASURER DETAILS -->
                        <!-- <div> 
                            <b>Treasurer Details: </b> 
                            <?php
                                $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::APPROVED_BY_TREASURER, Constant::DECLINED_BY_TREASURER], true);
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
                        </div>    -->
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