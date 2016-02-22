<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th colspan=7>ITEMS IN STOCKS</th>
        </tr>
        <tr>
            <td> Attach Item to Requisition </td>
            <th>Name</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody id="ItemInStock">
        <?php $emptySearch = 0; ?>
        <?php if ($stockNames): ?>
                <?php foreach ($stockNames as $key => $stockName): ?>
                        <?php
                            $searchItems = $stocksRepo->getAllStockByName($stockName);

                            if ($searchItems->num_rows == 0) {  $emptySearch += 1; }
                        ?>
                        <?php while($searchItems && $item = $searchItems->fetch_assoc()) { ?>
                            <?php if (0 == $index): ?>
                                <?php $firstItem = $item; ?>
                            <?php endif ?>
                            <tr data-original_stock_count="<?php echo $item['count_stocks'] ?>"  data-count_stocks="<?php echo $item['count_stocks']; ?>"  data-key="<?php echo trim($item['stock_name']); ?>" data-id="<?php echo $item['stock_id'] ?>" />
                                <?php if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT): ?>
                                    <td>
                                        <button type='button' class="btn-primary btn-sm btn plus-item-stocks"><i class='fa fa-plus'></i></button> 
                                        <button type='button' class="btn-warning btn-sm btn minus-item-stocks"><i class='fa fa-minus'></i></button>
                                    </td>
                                <?php endif ?>
                                <td><?php echo $item['stock_name'] ?></td>
                                <td class='count-stocks'><?php echo $item['count_stocks'] ?></td>
                                <td><?php echo strtoupper($item['stock_unit']); ?></td>
                                <td><?php echo $item['stock_type'] ?></td>
                            </tr>
                        <?php } ?>
                <?php endforeach ?>
        <?php endif ?>

        <?php if($emptySearch == sizeof($stockNames)) : ?>
            <tr class='info'>
                <td colspan=5 > No Same Items Found In Stocks </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>