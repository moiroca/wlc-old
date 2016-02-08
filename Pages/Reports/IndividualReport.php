<?php
	include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

	Login::sessionStart();
	if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

	if (isset($_GET['control_identifier'])) { $controlIdentifier = $_GET['control_identifier']; } else { throw new Exception('Page Not Found'); }

	$requisitionObj = new Requisitions();
	$requisition = $requisitionObj->getRequisitionByControlIdentifier($controlIdentifier);

	if ($requisition && 0 != $requisition->num_rows) {
	    $requisition = $requisition->fetch_assoc();
	} else {
		echo json_encode(['error' => true, 'msg' => 'Control Indentifier Not Found']);
		die();
	}

	//--. Get Requisition Current Status .--//
	$requisitionCurrentStatus = $requisitionObj->getCurrentRequisitionStatus($requisition['requisition_id']);

	$userObj = new User();
	$stocksRepo = new Stocks();
	$departmentRepo = new Department();

	if ($requisitionCurrentStatus == Constant::ITEM_VERIFIED_BY_PRESIDENT) {
		$status = Constant::STOCK_APPROVED;
	} else if ($requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER) {
		$status = Constant::STOCK_RECEIVED;
	} else {
		$status = false;
	}

	$itemsInRequisition = ($requisition['requisition_type'] == Constant::REQUISITION_JOB) ? 
							$stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']) :
							$stocksRepo->getApprovedItemInRequisition($requisition['requisition_id'], $status); 				

	$firstItem = ($itemsInRequisition) ? $itemsInRequisition->fetch_assoc() : null; 

	$itemsInRequisition = ($requisition['requisition_type'] == Constant::REQUISITION_JOB) ? 
							$stocksRepo->getAllStockByRequisitionIdTypeJOB($requisition['requisition_id']) :
							$stocksRepo->getApprovedItemInRequisition($requisition['requisition_id'], $status);
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WLC FACILITIES AND EQUIPMENT - Inventory and Monitoring System</title>

    <?php
    	Assets::renderCss([
            'bootstrap.min.css',
            'font-awesome.min.css'
        ]); 
    ?>
    <!-- Le styles -->
    <style>
      body {
        background-color:#e3e3e3;
      }
    </style> 
</head>
<body bgcolor="gray">
<br>
<style>
#container{
	min-height: 1200px;	
	margin: 0 auto;
	width: 900px;
	background-color:white;
	padding: 10px 50px;
}
#header{
	margin: 10px auto;
	padding: 10px;

	border-bottom: 1px solid #e3e3e3;
}

#header p {
	font-size: 14px;
	line-height: 10px;
}

.local-signee {
	margin-top: 40px;
	border-top: 1px solid #000;
	padding-top: 10px;
}

</style>
<div id="container">
	<div id="header" class="row">
		<div class="col-lg-2">
			<img width='100'; src="../../images/school.jpg">
		</div>
		<div class="col-lg-8" align="center">
			<p><b>WESTERN LEYTE COLLEGE OF ORMOC INC.</b></p>
			<p><i>BONIFACIO ST. ORMOC, CITY</i></p>
			<p><i>
				<?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
					REPORT OF REPAIRS AND MAINTENANCE	
				<?php else: ?>
					NEW ITEM REQUISITION
				<?php endif ?>
			</i></p>
			<p>Date: <i style='text-decoration:underline'><?php echo date_create($requisition['datetime_added'])->format('M d, Y'); ?></i></p>
		</div>
		<div class="col-lg-2">
			<img width='100'; src="../../images/ict.jpg">
		</div>
	</div>
	
	<div id="content" class="row">
		<?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
			<div class="col-lg-12">
				<p><b>Department</b>: <i><?php echo $requisition['requisition_department_name']; ?></i></p>
				<p><b>Area for Repair/Maintenance</b>: <i><?php echo $requisition['requisition_area_name']; ?></i></p>
			</div>

			<div class="col-lg-12" style="margin-top:30px; border-bottom: 1px solid #000;">
				<p><b>Nature of Complaint:</b></p>
				<p><?php echo $requisition['requisition_purpose']; ?></p>
			</div>
		<?php endif; ?>

		<?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
			<div class="col-lg-12" style='margin-top: 40px;' align=center>
				<b>REQUISITIONS AND ISSUE VOUCHER</b>
				<?php if ($firstItem): ?>
					<p>( <i><?php echo $firstItem['stock_type'] ?></i> )</p>
				<?php endif ?>
			</div>
		<?php endif; ?>
		<div class="col-lg-12" style="margin-top:20px;">
			<table class="table table-bordered" id='stocks_in_requisition'>
                    <thead>
                        <tr>
                            <th colspan="6"> 
                                <p class='pull-left' style=';'>Approved ITEMS IN REQUISITION</p> 
                            </th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Price (in PHP)</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Item Status</th>
                            <th>Status</th>
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
                                    <td><?php echo $item['stock_name'] ?></td>
                                    <td><?php echo $item['stock_price'] ?></td>
                                    <?php $total += $item['stock_price']; ?>
                                    <td><?php echo $item['stock_type'] ?></td>
                                    <td><?php echo $item['area_name']; ?></td>
                                    <td><?php echo $item['stock_status']; ?></td>
                                    <td class='status'>
                                        <?php if ($item['stock_requisition_status'] == Constant::STOCK_APPROVED): ?>
                                            <label class="label label-info"><?php echo $item['stock_requisition_status']; ?></label>    
                                        <?php elseif($item['stock_requisition_status'] == Constant::STOCK_RECEIVED): ?>
                                            <label class="label label-success"><?php echo $item['stock_requisition_status']; ?></label>    
                                        <?php else: ?>
                                        	<label class="label label-info">Item not yet received or approved</label>    
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <?php $index++; ?>
                            <?php } ?>
                                <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                    <tr>
                                        <td > <span class='pull-right'><b>TOTAL</b></span></td>
                                        <td colspan="6"><span class='pull-left'><?php echo $total; ?> PHP</span></td>
                                    </tr>
                                <?php endif ?>
                        <?php else: ?>
                                <tr>
                                    <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                                </tr>
                        <?php endif ?>
                    </tbody>
            </table>

            <!--
			<table class='table table-bordered'>
				<thead>
					<tr>
                        <th>Control Identifier</th>
                        <th>Name</th>
                        <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                            <th>Quantity</th>
                        <?php endif ?>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Condition</th>
                        <?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
                            <th>Updated To</th>
                            <th>Type</th>
                        <?php endif ?>
                    </tr>
				</thead>
				<tbody>
					<?php if ($itemsInRequisition && 0 != $itemsInRequisition->num_rows): ?>
                        <?php $total = 0; $index = 0; ?>

                        <?php while($item = $itemsInRequisition->fetch_assoc()) { ?>
                            <?php if (0 == $index): ?>
                                <?php $firstItem = $item; ?>
                            <?php endif ?>
                            <tr data-id="<?php echo $item['stock_id'] ?>" class="<?php echo ($item['stock_isRequest'] == 'FALSE') ? "success" : ""; ?>" />
                                <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                <?php endif ?>
                                <td><?php echo $item['stock_control_number'] ?></td>
                                <td><?php echo $item['stock_name'] ?></td>
                                <?php $stockNames[] = $item['stock_name']; ?>

                                <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                    <td>
                                        <?php if ($requisitionCurrentStatus != Constant::APPROVED_BY_PRESIDENT && Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                            <input class='form-control input-sm' type='number' min=1 value="<?php echo $item['count_stocks'] ?>">
                                        <?php else: ?>
                                            <?php echo $item['count_stocks'] ?>
                                        <?php endif ?>
                                    </td>
                                <?php endif ?>
                                <td><?php echo $item['stock_price'] ?></td>
                                <td><?php echo strtoupper($item['stock_unit']); ?></td>
                                <td><?php echo $item['stock_status'] ?></td>
                                <?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
                                	<td><?php echo strtoupper($item['stock_update']); ?></td>
                                	<td><?php echo $item['stock_type'] ?></td>
                            	<?php endif ?>
                                <?php $total += $item['total_stock_price']; ?>
                            </tr>
                            <?php $index++; ?>
                        <?php } ?>
                            <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                                <tr>
                                    <td colspan="3"> <span class='pull-right'><b>TOTAL</b></span></td>
                                    <td colspan="3"><span class='pull-left'>PHP <?php echo $total; ?></span></td>
                                </tr>
                            <?php endif ?>
                    <?php else: ?>
                            <tr>
                                <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                            </tr>
                    <?php endif ?>
				</tbody>
			</table>

			-->
			<div class="col-lg-12" style='margin-top:10px;'>
				<div class='col-lg-4'>
					<p><b>Reported By:</b></p>
					<p><i><b>Signed</b>: <?php echo RequesterUtility::getFullName($requisition); ?></i></p>
					<p><b>Name of Employee</b></p>
				</div>
				<div class="col-lg-4">
					<?php 
						$department = $departmentRepo->getDepartmentHeadByDepartmentId($requisition['requisition_department_id']); 
						
						$departmentHead = $department->fetch_assoc();
					?>
					<p><b>Confirmed By:</b></p>
					<p class="local-signee"><i>
						<?php if ($departmentHead): ?>
							<?php echo RequesterUtility::getFullName($departmentHead);?>
						<?php else: ?>
							<label class='label label-info'> Department Head Not Set </label>
						<?php endif ?>
					</i></p>
					<p><b>Department Head</b></p>
				</div>
				<div class="col-lg-4">
					<?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
						<?php 
							$president = $userObj->getAll(['firstname as user_firstname', 'lastname as user_lastname'], ['type' => Constant::USER_PRESIDENT]);
							$president = ($president) ? $president->fetch_assoc() : $president;
						?>
						<p><b>Noted and Approved By:</b></p>
						<p><i>
							<?php if ($president): ?>
								<?php 
	                              $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::RECEIVED_BY_REQUESTER, Constant::ITEM_VERIFIED_BY_PRESIDENT, Constant::APPROVED_BY_PRESIDENT, Constant::DECLINED_BY_PRESIDENT], true);
		                        ?>
		                        <?php if ($actor && $requisitionCurrentStatus == Constant::APPROVED_BY_PRESIDENT || 
		                        			$requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER || 
		                        			$requisitionCurrentStatus == Constant::ITEM_VERIFIED_BY_PRESIDENT) { ?>
		                            <b>Signed:</b> <?php echo RequesterUtility::getFullName($actor); ?>
		                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
		                        <?php } elseif($actor && $requisitionCurrentStatus == Constant::DECLINED_BY_PRESIDENT){ ?>
		                        	<?php echo RequesterUtility::getFullName($actor); ?>
		                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
		                        <?php } elseif ($requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER){ ?>
		                        	<label class='label label-danger'> This is no more available. </label>
		                        <?php } else { ?>
		                        	<label class='label label-info'>Not Yet Signed By President</label>
		                        <?php } ?>
							<?php else: ?>
								<label class='label label-info'> President Not Set </label>
							<?php endif ?>
						</i></p>
						<p><b>President</b></p>
					<?php else: ?>
						<p><b>Department</b> </p>
						<u><?php echo $requisition['requisition_department_name']; ?></u>
					<?php endif ?>
				</div>
			</div>
			<div class="col-lg-12" style='margin-top:40px;'>
				<div class="col-lg-6">
					<?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
						<?php 
							$gsdOfficer = $userObj->getAll(['firstname as user_firstname', 'lastname as user_lastname'], ['type' => Constant::USER_GSD_OFFICER]);
							$gsdOfficer = ($gsdOfficer) ? $gsdOfficer->fetch_assoc() : $gsdOfficer;
						?>
						<p><b>Date Received:</b></p>
						<p><i>
							<?php if ($gsdOfficer): ?>
								<?php 
		                              $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::VERIFIED_BY_GSD_OFFICER, Constant::DECLINED_BY_GSD_OFFICER], true);
		                        ?> 
		                        <?php if ($actor && RequisitionUtility::isRequisitionActionedByPropertyCustodianOrGSDOfficer($requisitionCurrentStatus, true)) { ?>
		                              <b>Signed:</b> <?php echo RequesterUtility::getFullName($gsdOfficer);?>
		                        <?php } elseif ($actor && $requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER){ ?>
		                        	<?php echo RequesterUtility::getFullName($actor); ?>
		                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
		                        <?php } else { ?>
		                        	<label class='label label-info'>Not Yet Signed By GSD Officer</label>
		                        <?php } ?>
							<?php else: ?>
								<label class='label label-info'> GSD Officer Not Set </label>
							<?php endif ?>
						</i></p>
						<p><b>GSD Officer</b></p>
					<?php else: ?>
						<?php 
							$comptroller = $userObj->getAll(['firstname as user_firstname', 'lastname as user_lastname'], ['type' => Constant::USER_COMPTROLLER]);
							$comptroller = ($comptroller) ? $comptroller->fetch_assoc() : $comptroller;
						?>
						<p><b>Approved As to Availability of Fund: </b></p>
						<p class='local-signee'><i>
							<?php if ($comptroller): ?>
								<?php echo RequesterUtility::getFullName($comptroller);?>
							<?php else: ?>
								<label class='label label-info'> Comptroller Not Set </label>
							<?php endif ?>
						</i></p>
						<p><b>Comptroller</b></p>
					<?php endif; ?>
				</div>
				<div class="col-lg-2"></div>
				<div class="col-lg-4">
					<?php if ($requisition['requisition_type'] == Constant::REQUISITION_JOB): ?>
						
						<p class='local-signee'><i>
							<?php if ($treasurer): ?>
								<?php echo RequesterUtility::getFullName($treasurer);?>
							<?php else: ?>
								<label class='label label-info'> Treasurer Not Set </label>
							<?php endif ?>
						</i></p>
						<p><b>Treasurer</b></p>
					<?php else: ?>

						<?php if ($firstItem && $firstItem['stock_type'] == Constant::ITEM_MATERIAL_EQUIPMENT): ?>
								<?php 
									$gsdOfficer = $userObj->getAll(['firstname as user_firstname', 'lastname as user_lastname'], ['type' => Constant::USER_GSD_OFFICER]);
									$gsdOfficer = ($gsdOfficer) ? $gsdOfficer->fetch_assoc() : $gsdOfficer;
								?>
								<p><b>Verified By:</b></p>
								<p><i>
									<?php if ($gsdOfficer): ?>
										<?php 
				                              $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::VERIFIED_BY_GSD_OFFICER, Constant::DECLINED_BY_GSD_OFFICER], true);
				                        ?> 
				                        <?php if ($actor && RequisitionUtility::isRequisitionActionedByPropertyCustodianOrGSDOfficer($requisitionCurrentStatus, true)) { ?>
				                              <b>Signed:</b> <?php echo RequesterUtility::getFullName($gsdOfficer);?>
				                        <?php } elseif ($actor && $requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER){ ?>
				                        	<?php echo RequesterUtility::getFullName($actor); ?>
				                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
				                        <?php } else { ?>
				                        	<label class='label label-info'>Not Yet Signed By GSD Officer</label>
				                        <?php } ?>
									<?php else: ?>
										<label class='label label-info'> GSD Officer Not Set </label>
									<?php endif ?>
								</i></p>
								<p><b>GSD Officer</b></p>
                        <?php else: ?>
                             	<?php 
									$propertyCustodian = $userObj->getAll(['firstname as user_firstname', 'lastname as user_lastname'], ['type' => Constant::USER_PROPERTY_CUSTODIAN]);
									$propertyCustodian = ($propertyCustodian) ? $propertyCustodian->fetch_assoc() : $propertyCustodian;
								?>
								<p><b>Verified By:</b></p>
								<p><i>
									<?php if ($propertyCustodian): ?>
										<?php 
				                              $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::VERIFIED_BY_PROPERTY_CUSTODIAN, Constant::DECLINED_BY_PROPERTY_CUSTODIAN], true);
				                        ?> 
				                        <?php if ($actor && RequisitionUtility::isRequisitionActionedByPropertyCustodianOrGSDOfficer($requisitionCurrentStatus, true)) { ?>
				                              <b>Signed:</b> <?php echo RequesterUtility::getFullName($propertyCustodian); ?>
				                        <?php } elseif ($actor && $requisitionCurrentStatus == Constant::DECLINED_BY_PROPERTY_CUSTODIAN){ ?>
				                        	<?php echo RequesterUtility::getFullName($actor); ?>
				                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
				                        <?php } else { ?>
				                        	<label class='label label-info'>Not Yet Signed By Property Custodian</label>
				                        <?php } ?>
									<?php else: ?>
										<label class='label label-info'> Property Custodian Not Set </label>
									<?php endif ?>
								</i></p>
								<?php if ($propertyCustodian): ?>
									<?php echo RequesterUtility::getFullName($propertyCustodian); ?>
								<?php endif; ?>
								<p><b>Property Custodian</b></p>
                        <?php endif ?>
					<?php endif; ?>
				</div>
			</div>

			<?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
				<div class="col-lg-8"></div>
				<div class="col-lg-4">
					<?php 
						$president = $userObj->getAll(['firstname as user_firstname', 'lastname as user_lastname'], ['type' => Constant::USER_PRESIDENT]);
						$president = ($president) ? $president->fetch_assoc() : $president;
					?>
					<p><b>Approved By:</b></p>
					<p><i>
						<?php if ($president): ?>
							<?php 
	                          $actor = $requisitionObj->getRequisitionActorByStatus($requisition['requisition_id'], [Constant::APPROVED_BY_PRESIDENT, Constant::DECLINED_BY_PRESIDENT], true);
	                        ?>
	                        <?php if ($actor && $requisitionCurrentStatus == Constant::APPROVED_BY_PRESIDENT || 
	                        			$requisitionCurrentStatus == Constant::RECEIVED_BY_REQUESTER || 
	                        			$requisitionCurrentStatus == Constant::ITEM_VERIFIED_BY_PRESIDENT) { ?>
	                            <b>Signed:</b> <?php echo RequesterUtility::getFullName($actor); ?>
	                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
	                        <?php } elseif($actor && $requisitionCurrentStatus == Constant::DECLINED_BY_PRESIDENT){ ?>
	                        	<?php echo RequesterUtility::getFullName($actor); ?>
	                            <p><?php echo RequisitionDecorator::status($requisitionCurrentStatus); ?></p>
	                        <?php } elseif ($requisitionCurrentStatus == Constant::DECLINED_BY_GSD_OFFICER){ ?>
	                        	<label class='label label-danger'> This is no more available. </label>
	                        <?php } else { ?>
	                        	<label class='label label-info'>Not Yet Signed By President</label>
	                        <?php } ?>
						<?php else: ?>
							<label class='label label-info'> President Not Set </label>
						<?php endif ?>
					</i></p>
					<?php if ($president): ?>
						<?php echo RequesterUtility::getFullName($president); ?>
					<?php endif ?>
					<p><b>President</b></p>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div id="footer">
	</div>
</div>




