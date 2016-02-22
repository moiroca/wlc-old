<?php 
    $isLoggedInOwner = (Login::getUserLoggedInId() == $requisition['requisition_requester_id']);
?>
<?php if ($isLoggedInOwner): ?>
    <div class='alert alert-info'>
        <i class='fa fa-info'></i> Click Checkbox to Mark as Received
    </div>
<?php endif ?>
<table class="table table-bordered table-hover table-striped" id='stocks_in_requisition'>
        <thead>
            <tr>
                <th colspan="<?php echo ($isLoggedInOwner) ? 6 : 5; ?>"> 
                    <p class='pull-left' style=';'>Approved ITEMS IN REQUISITION</p> 
                    <?php if ($isLoggedInOwner): ?>
                        <button class='btn btn-primary pull-right' type='button' id='receivedBtn'>Receive</button>
                    <?php endif ?>
                </th>
            </tr>
            <tr>
                <?php if ($isLoggedInOwner): ?>
                    <th> <input type='checkbox' id='checkAllItem' name=[]></th>
                <?php endif ?>
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
                        <?php $itemsToApprove[] = $item; ?>
                        <?php if ($isLoggedInOwner): ?>
                            <td><input <?php echo ($item['stock_status'] == Constant::STOCK_RECEIVED) ? 'checked="checked"' : ''; ?> class='stock' type='checkbox' name="ids[]" value='<?php echo $item['stock_id']; ?>'></td>
                        <?php endif ?>
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
                            <td colspan="<?php echo ($isLoggedInOwner) ? 5 : 4; ?>"><span class='pull-left'><?php echo $total; ?> PHP</span></td>
                        </tr>
                    <?php endif ?>
            <?php else: ?>
                    <tr>
                        <td colspan=7 class='alert alert-info'> There is no stock attached. </td>
                    </tr>
            <?php endif ?>
        </tbody>
</table>