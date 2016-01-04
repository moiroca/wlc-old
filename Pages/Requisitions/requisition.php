<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

if (isset($_GET['control_identifier'])) { $controlIdentifier = $_GET['control_identifier']; } else { throw new Exception('Page Not Found'); }

$requisitionObj = new Requisitions();
$requisition = $requisitionObj->getRequisitionByControlIdentifier($controlIdentifier)->fetch_assoc();

$userObj = new User();
$stocksRepo = new Stocks();

$itemsInRequisition = $stocksRepo->getStockByRequisitionId($requisition['requisition_id']);

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
                    <?php if ($requisition['requisition_status'] == Constant::REQUISITION_APPROVED): ?>
                        <div class="alert alert-success">
                            <i class='fa fa-thumbs-up fa-5x'></i><label style="font-size:40px;"> REQUISITION APPROVED!</label>
                        </div>
                    <?php elseif ($requisition['requisition_status'] == Constant::REQUISITION_DECLINED): ?>
                        <div class="alert alert-danger">
                            <i class='fa fa-thumbs-down fa-5x'></i><label style="font-size:40px;">   REQUISITION DECLINED!</label>
                        </div>
                    <?php endif ?>

                    <input type='hidden' value="<?php echo Link::createUrl('Controllers/approveItemInRequisition.php'); ?>" id="approve_item_in_requisition" />
                    <table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
                        <thead>
                            <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                <tr>
                                    <th colspan=6>
                                        <button id="approve-btn" type='button' class='btn btn-sm btn-primary'> <i class='fa fa-thumbs-up'></i> Approve</button>
                                        <!-- <button id='decline-btn' type='button' class='btn btn-sm btn-warning'> <i class='fa fa-thumbs-down'></i> Declined</button> -->
                                    </th>
                                </tr>    
                            <?php endif ?>
                            <tr>
                                <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                    <th>
                                        <input class='select-all' type='checkbox' id='checkAllItem' />
                                    </th>
                                <?php endif ?>
                                <th>Control Identifier</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Condition</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $firstItem = ''; ?>
                            <?php if (0 != $itemsInRequisition->num_rows): ?>
                                <?php $total = 0; $index = 0; ?>

                                <?php while($item = $itemsInRequisition->fetch_assoc()) { ?>
                                    <?php if (0 == $index): ?>
                                        <?php $firstItem = $item; ?>
                                    <?php endif ?>
                                    <tr data-id="<?php echo $item['stock_id'] ?>" class="<?php echo ($item['stock_isRequest'] == 'FALSE') ? "success" : ""; ?>" />
                                        <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                            <td>
                                                <input type='checkbox' class='check-box' <?php echo ($item['stock_isRequest'] == 'FALSE') ? "checked" : ""; ?> />
                                            </td>
                                        <?php endif ?>
                                        <td><?php echo $item['stock_control_number'] ?></td>
                                        <td><?php echo $item['stock_name'] ?></td>
                                        <td><?php echo $item['stock_price'] ?></td>
                                        <td><?php echo strtoupper($item['stock_unit']); ?></td>
                                        <td><?php echo $item['stock_status'] ?></td>
                                        <td><?php echo $item['stock_type'] ?></td>
                                        <?php $total += $item['stock_price'];?>
                                    </tr>
                                    <?php $index++; ?>
                                <?php } ?>
                                    <tr>
                                        <td colspan="<?php echo (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) ? 3 : 2; ?>"> <span class='pull-right'>TOTAL</span></td>
                                        <td colspan="4"><span class='pull-left'><?php echo $total; ?></span></td>
                                    </tr>
                            <?php else: ?>
                                    <tr>
                                        <td colspan=5 class='alert alert-info'> There is no stock attached. </td>
                                    </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
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
                            <?php echo $requisition['requisition_status']; ?>
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
                    <div> 
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
                        </div>   

                        <!--TREASURER DETAILS -->
                        <div> 
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
                            </div>
                        <?php endif ?>
                        
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
                        </div>
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
                    </div>
            </div>
        </div>
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>