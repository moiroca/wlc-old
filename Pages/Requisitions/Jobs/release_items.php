<!-- Items List -->
<form method="POST" action="<?php echo Link::createUrl('Controllers/ReleaseItemsJobRequisition.php'); ?>">
<table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
    <input type='hidden' name='requisitionId' value="<?php echo $requisition['requisition_id']; ?>">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
            <th>Replaced With</th>
        </tr>
    </thead>
    <tbody id="tempItemsForApproval">
        <?php if ($itemsInRequisition && 0 != $itemsInRequisition->num_rows): ?>
            <?php $total = 0; $index = 0; ?>

            <?php while($item = $itemsInRequisition->fetch_assoc()) { ?>
                <input type='hidden' name='itemIds[]' value='<?php echo $item['stock_id']; ?>'>
                <tr data-id='<?php echo $item['stock_id']; ?>'>
                    <td><?php echo $item['stock_name'] ?></td>
                	<td>
			            <?php echo $item['stock_status']; ?>
                	</td>
                    <td>
                        <?php if (Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER): ?>
                            <?php if ($item['stock_status'] == Constant::STOCK_FOR_REPAIR): ?>
                                <select name='action[<?php echo $item['stock_id']; ?>]' class='form-control'>
                                    <option value='<?php echo Constant::STOCK_REPAIRED; ?>'><?php echo Constant::STOCK_REPAIRED; ?></option>
                                    <option value='<?php echo Constant::STOCK_OBSOLETE; ?>'><?php echo Constant::STOCK_OBSOLETE; ?></option>
                                </select>
                            <?php elseif ($item['stock_status'] == Constant::STOCK_FOR_REPLACEMENT): ?>
                                <button type='button' class='btn btn-primary replace-item-btn'>Replace Item With</button>
                            <?php else: ?>
                                <label class="label label-info">No Action Found</label>
                            <?php endif ?>
                        <?php else: ?>
                            <?php echo $item['stock_status']; ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($item['stock_status'] == Constant::STOCK_FOR_REPLACEMENT): ?>
                            <span class='item-for-replace' data-item_id='0'></span>
                            <input class='replacement-item-id' type='hidden' name='itemForReplaceIds[<?php echo $item['stock_id']; ?>]' value='0'>
                        <?php else: ?>
                            <label class="label-info label"> <i class='fa fa-info'></i> Not Applicable</label>
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
    <tfoot>
        <tr >
            <td colspan=4><input type='submit' value='Release Items' class='btn btn-primary btn-large'></td>
        </tr>
    </tfoot>
</table>
</form>
<div id='attached_item_group' class="control-group" style='display:none' data-item_id='0'>
    <label class='control-label' for="purpose"> Attach Item by searching Item Control Identifier</label>    
    <div class="form-group input-group">
            <span class="input-group-addon">
              Control Identifier
            </span>
            <input placeholder='Enter Control Identifier' id='item_control_number' type="text" class="form-control">
            <span class="input-group-btn">
              <button type='button' id='search_control_number_for_replace' class="btn btn-default" type="button">
                <i class="fa fa-search"></i>
              </button>
            </span>
    </div>
    <p style='display:none;' class="help-block alert alert-danger"></p>
    <table style='display:none' class="table table-hover table-striped requisitionItems" id='item_table'>
        <thead>
            <tr class='itemForm'>
                <th>Item Control Identifier</th>
                <th>Item Name</th>
                <th>Area</th>
                <th>Item Condition</th>
                <th>Item Type</th>
                <th>Action</th>
             </tr>
            <tr id='empty' class='info itemForm'>
                <td colspan=6 align=center><label class='label label-primary'>No Item Found</label></td>
            </tr>
            <tr id='loader' style='display:none' class='itemForm'>
                <td colspan=6 align=center><i class='fa fa-spinner fa-spin fa-2x'></i></td>
            </tr>
            <tr id='result' class='info itemForm'>
            </tr>
        </thead>
        <tbody id='item_list' class='itemForm'>
        </tbody>
    </table>
</div>
<span id='links'>
  <input id='searchRequisitionLink' type='hidden' value='<?php echo Link::createUrl('Controllers/SearchRequisition.php'); ?>'/>
</span>