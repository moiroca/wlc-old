<table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
        <thead>
            <tr>
                <th>Name</th>
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
                        
                        <td><?php echo $item['stock_name'] ?></td>
                        <td><?php echo $item['stock_type'] ?></td>
                        <td>
                            <?php 
                                $area = $stocksRepo->getStockCurrentLocation($item['stock_id'])->fetch_assoc();
                                echo $area['area_name'];
                            ?>
                        </td>
                        <td class='status'>
                            <?php if ($item['stock_status'] == Constant::STOCK_APPROVED): ?>
                                <label class="label label-info"><?php echo $item['stock_status']; ?></label>    
                            <?php else: ?>
                                <label class="label label-success"><?php echo $item['stock_status']; ?></label>    
                            <?php endif ?>
                        </td>
                    </tr>
                    <?php $index++; ?>
                <?php } ?>
                    <?php if ($requisition['requisition_type'] == Constant::REQUISITION_ITEM): ?>
                        <tr>
                            <td > <span class='pull-right'><b>TOTAL</b></span></td>
                            <td colspan="4"><span class='pull-left'><?php echo $total; ?> PHP</span></td>
                        </tr>
                    <?php endif ?>
            <?php else: ?>
                    <tr>
                        <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                    </tr>
            <?php endif ?>
        </tbody>
</table>