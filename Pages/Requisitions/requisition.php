<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

if (isset($_GET['control_identifier'])) { $controlIdentifier = $_GET['control_identifier']; } else { throw new Exception('Page Not Found'); }

$requisitionObj = new Requisitions();
$requisition = $requisitionObj->getRequisitionByControlIdentifier($controlIdentifier)->fetch_assoc();

$userObj = new User();
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
	                                $user = $userObj->getAll(['*'], ['id' => $requisition['requisition_gsd_officer_id']])->fetch_assoc();
	                                echo $user['lastname'].', '.$user['firstname'];
	                            ?>
    						</p>
    					</li>
    				</ul>
    			</div>
    			<div> 
    				<b>GSD Officer Approver Details: </b> 
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
    							<?php if (!is_null($requisition['requisition_gsd_officer_id'])): ?>
    								<?php echo $requisition['requisition_datetime_approveddeclined_by_gsd_officer']; ?>
    							<?php else: ?>
    								<label class='label label-info'>Not Available</label>
    							<?php endif ?>
    						</p>
    					</li>
    					<li>
    						<p>
    							<b>Declined Datetime: </b> 
    							<?php if (!is_null($requisition['requisition_gsd_officer_id'])): ?>
    								<label class='label label-info'>Not Available</label>
    							<?php else: ?>
    								<?php echo $requisition['requisition_datetime_approveddeclined_by_gsd_officer']; ?>
    							<?php endif; ?>
    						</p>
    					</li>
    				</ul>
    			</div>
    			<div> 
    				<b>President Approver Details: </b> 
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
    							<?php if (!is_null($requisition['requisition_president_id'])): ?>
    								<?php echo $requisition['requisition_datetime_approveddeclined_by_president']; ?>
    							<?php else: ?>
    								<label class='label label-info'>Not Available</label>
    							<?php endif ?>
    						</p>
    					</li>
    					<li>
    						<p>
    							<b>Declined Datetime: </b> 
    							<?php if (!is_null($requisition['requisition_president_id'])): ?>
    								<?php echo $requisition['requisition_datetime_approveddeclined_by_president']; ?>
    							<?php else: ?>
    								<label class='label label-info'>Not Available</label>
    							<?php endif; ?>
    						</p>
    					</li>
    				</ul>
    			</div>
    		</div>
    	</div>
    </div>
  </div>
<?php Template::footer(); ?>