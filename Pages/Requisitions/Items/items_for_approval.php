<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th colspan=7>ITEMS TO APPROVE</th>
        </tr>
        <tr>
            <th>Name</th>
            <th>From Item Requisition</th>
            <th>From Item Stocks</th>
            <th>Total Quantity</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody id='itemsForApproval'>

        <?php if ($itemsToApprove): ?>
            <?php foreach ($itemsToApprove as $key => $item): ?>
                <tr data-key="<?php echo trim($item['stock_name']); ?>" data-count_stocks="<?php echo $item['count_stocks'] ?>">
                    <td><?php echo $item['stock_name'] ?></td>
                    <td class='from-item-requisition'><?php echo $item['count_stocks'] ?></td>
                    <td class='from-item-stocks'>0</td>
                    <td class='count-stocks'><?php echo $item['count_stocks'] ?></td>
                    <td><?php echo $item['stock_unit']; ?></td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr class='info'>
                <td colspan=8 > No Item to Approve </td>
            </tr>    
        <?php endif ?>
        
    </tbody>
    <tfoot>
        <tr>
            <td colspan=8> <button type='button' id='approveRequisitionButton' class="btn btn-lg btn-primary"> Approve Item(s) In Requisition </button></td>
        </tr>
    </tfoot>
</table>