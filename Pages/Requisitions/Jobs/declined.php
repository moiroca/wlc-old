<!-- Items List -->
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
                    
                	<td><?php echo $item['stock_status']; ?></td>
                </tr>
            <?php } ?>
        <?php else: ?>
                <tr>
                    <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                </tr>
        <?php endif ?>
    </tbody>
</table>