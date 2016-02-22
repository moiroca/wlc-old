<!-- Items List -->
<form method="POST" action="<?php echo Link::createUrl('Controllers/SavePendingJobRequisition.php'); ?>">
<table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
    <input type='hidden' name='requisitionId' value="<?php echo $requisition['requisition_id']; ?>">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Area</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="tempItemsForApproval">
        <?php if ($itemsInRequisition && 0 != $itemsInRequisition->num_rows): ?>
            <?php while($item = $itemsInRequisition->fetch_assoc()) { ?>
                <tr data-id='<?php echo $item['stock_id']; ?>'>
                    <td><?php echo $item['stock_name'] ?></td>
                    <td><?php echo $item['stock_type'] ?></td>
                    <td>
                    	<?php
                    		$area = $stocksRepo->getStockCurrentLocation($item['stock_id'])->fetch_assoc();
                    		echo $area['area_name'];
                    	?>
                    </td>
                    
                	<td>
                		<input type='hidden' name='ids[]' value="<?php echo $item['stock_id']; ?>">
                		<?php if (Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER): ?>
		            		<select class='form-control' name='statuses[]'>
                    			<?php foreach (RequisitionUtility::getRequisitionStockStatuses() as $key => $status): ?>
                    				<option <?php echo ($status == $item['stock_status']) ? 'selected="selected"' : '' ?> value='<?php echo $status ?>'><?php echo $status ?></option>
                    			<?php endforeach ?>
                    		</select>
            			<?php else: ?>
			            		<?php echo $item['stock_status']; ?>
			            <?php endif ?>
                	</td>
                </tr>
            <?php } ?>
        <?php else: ?>
                <tr>
                    <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                </tr>
        <?php endif ?>
    </tbody>
    <?php if (Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER): ?>
        <tfoot>
            <tr>
                <td colspan=5>
                    <div class="control-group">
                        <label>APPROVE/DECLINED</label>
                        <select class="form-control" name='status'>
                            <option value='<?php echo Constant::VERIFIED_BY_GSD_OFFICER; ?>'><?php echo Constant::VERIFIED_BY_GSD_OFFICER; ?></option>
                            <option value='<?php echo Constant::DECLINED_BY_GSD_OFFICER; ?>'><?php echo Constant::DECLINED_BY_GSD_OFFICER; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=5>
                    <input type='submit' class='form-control btn btn-primary' value="Save">
                </td>
            </tr>
        </tfoot>
    <?php endif ?>
</table>
</form>