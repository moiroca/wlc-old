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
    <div class="col-md-12">
    	<div class="panel panel-info">
    		<div class="panel-heading"> 
    			<label class="panel-title">Requisition Details</label>
    		</div>
    		<div class="panel-body">
    			<div class="row">
                    <div class="col-lg-4">
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
                                <?php if ($requisition['requisition_status'] == Constant::REQUISITION_PENDING): ?>
                                    <?php echo $requisition['requisition_status']; ?>
                                <?php elseif(!is_null($requisition['requisition_gsd_officer_id']) && is_null($requisition['requisition_president_id'])) : ?>
                                    <?php echo $requisition['requisition_status']; ?> By GSD Officer
                                <?php elseif(is_null($requisition['requisition_gsd_officer_id']) && !is_null($requisition['requisition_president_id'])) : ?>
                                    <?php echo $requisition['requisition_status']; ?> By President
                                <?php elseif(!is_null($requisition['requisition_gsd_officer_id']) && !is_null($requisition['requisition_president_id'])) : ?>
                                    <?php echo $requisition['requisition_status']; ?> By President && GSD Officer
                                <?php endif; ?>
                            </p>
                        </div>
                        <div> 
                            <b>Requester Details: </b> 
                            <ul>
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
                        <div> 
                            <b>GSD Officer Details: </b> 
                            <ul>
                                <li>
                                    <p>
                                        <b>Name: </b> 
                                        <?php
                                            $user = $userObj->getAll(['*'], ['id' => $requisition['requisition_gsd_officer_id']])->fetch_assoc();
                                        ?>
                                        <?php if (!is_null($user)) { ?>
                                            <?php echo $user['lastname'].', '.$user['firstname']; ?>
                                        <?php } else { ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php } ?>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <b>Approved Datetime: </b> 
                                        <?php if (!is_null($requisition['requisition_gsd_officer_id']) && $requisition['requisition_status'] == Constant::REQUISITION_APPROVED ): ?>
                                            <?php echo $requisition['requisition_datetime_approveddeclined_by_gsd_officer']; ?>
                                        <?php else: ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php endif ?>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <b>Declined Datetime: </b> 
                                        <?php if (!is_null($requisition['requisition_gsd_officer_id']) && $requisition['requisition_status'] == Constant::REQUISITION_DECLINED ): ?>
                                            <?php echo $requisition['requisition_datetime_approveddeclined_by_gsd_officer']; ?>
                                        <?php else: ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php endif; ?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div> 
                            <b>President Details: </b> 
                            <ul>
                                <li>
                                    <p>
                                        <b>Name: </b> 
                                        <?php
                                            $user = $userObj->getAll(['*'], ['id' => $requisition['requisition_president_id']])->fetch_assoc();    
                                        ?>
                                        <?php if (!is_null($user)) { ?>
                                            <?php echo $user['lastname'].', '.$user['firstname']; ?>
                                        <?php } else { ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php } ?>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <b>Approved Datetime: </b> 
                                        <?php if (!is_null($requisition['requisition_president_id']) && $requisition['requisition_status'] == Constant::REQUISITION_APPROVED ): ?>
                                            <?php echo $requisition['requisition_datetime_approveddeclined_by_president']; ?>
                                        <?php else: ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php endif ?>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <b>Declined Datetime: </b> 
                                        <?php if (!is_null($requisition['requisition_president_id']) && $requisition['requisition_status'] == Constant::REQUISITION_DECLINED ): ?>
                                            <?php echo $requisition['requisition_datetime_approveddeclined_by_president']; ?>
                                        <?php else: ?>
                                            <label class='label label-info'>Not Available</label>
                                        <?php endif; ?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
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
                                    <th>Condition</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (0 != $itemsInRequisition->num_rows): ?>
                                    <?php $total = 0; ?>
                                    <?php while ($item = $itemsInRequisition->fetch_assoc()): ?>
                                        <tr data-id="<?php echo $item['stock_id'] ?>" class="<?php echo ($item['stock_isRequest'] == 'FALSE') ? "success" : ""; ?>" />
                                            <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                                <td>
                                                    <input type='checkbox' class='check-box' <?php echo ($item['stock_isRequest'] == 'FALSE') ? "checked" : ""; ?> />
                                                </td>
                                            <?php endif ?>
                                            <td><?php echo $item['stock_control_number'] ?></td>
                                            <td><?php echo $item['stock_name'] ?></td>
                                            <td><?php echo $item['stock_price'] ?></td>
                                            <td><?php echo $item['stock_status'] ?></td>
                                            <td><?php echo $item['stock_type'] ?></td>
                                            <?php $total += $item['stock_price'];?>
                                        </tr>
                                    <?php endwhile ?>
                                        <tr>
                                            <td colspan="<?php echo (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) ? 3 : 2; ?>"> <span class='pull-right'>TOTAL</span></td>
                                            <td colspan="3"><span class='pull-left'><?php echo $total; ?></span></td>
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
    	</div>
    </div>
  </div>
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>