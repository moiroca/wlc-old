<!-- Items List -->
<form method="POST" action="<?php echo Link::createUrl('Controllers/SavePendingJobRequisition.php'); ?>">
<table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
    <input type='hidden' name='requisitionId' value="<?php echo $requisition['requisition_id']; ?>">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price (in PHP)</th>
            <th>Type</th>
            <th>Area</th>
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
                    <td>
                    	<?php
                    		$area = $stocksRepo->getStockCurrentLocation($item['stock_id'])->fetch_assoc();
                    		echo $area['area_name'];
                    	?>
                    </td>
                    
                	<td>
			            <?php echo $item['stock_status']; ?>
                	</td>
                </tr>
                <?php $index++; ?>
            <?php } ?>
        <?php else: ?>
                <tr>
                    <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                </tr>
        <?php endif ?>
    </tbody>
</table>
</form>