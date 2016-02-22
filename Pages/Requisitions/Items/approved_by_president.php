<!-- Items List -->
<form method="POST" action="<?php echo Link::createUrl('Controllers/SavePendingJobRequisition.php'); ?>">
<table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
        <thead>
            <tr>
                <th colspan="<?php echo (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) ? 7 : 6; ?>"> ITEMS IN REQUISITION </th>
            </tr>
            <tr>
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
                        <td><?php echo $item['stock_name'] ?></td>
                        <?php $stockNames[] = $item['stock_name']; ?>

                        <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                            <td>
                                <?php echo $item['count_stocks'] ?>
                            </td>
                        <?php endif ?>
                        <td><?php echo $item['stock_price'] ?></td>
                        <td><?php echo strtoupper($item['stock_unit']); ?></td>
                        <td><?php echo $item['stock_type'] ?></td>
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