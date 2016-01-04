<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$stocks = new Stocks();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Materials</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Stocks</a>
              </li>
              <li class="active">
                  <i class="fa fa-table"></i> <a href="<?php echo Link::createUrl('Pages/Stocks/Materials/materials.php'); ?>">Materials</a>
              </li>
              <li>
                  <i class='fa fa-tasks'></i> <a href="<?php echo Link::createUrl('Pages/Stocks/add.php'); ?>">Add Item</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">

        <?php 

            $result = $stocks->getAllByType(Constant::ITEM_OFFICE_SUPPLY);
        ?>

        <?php if (isset($_SESSION['record_successful_added'])) { ?>
        <?php unset($_SESSION['record_successful_added']); ?>
            <div class="alert alert-success">
                Item Record Succesfully Added.
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['something_wrong'])) { ?>
        <?php unset($_SESSION['something_wrong']); ?>
            <div class="alert alert-danger">
                The System is still in development mode. Expect more bugs to come. 
            </div>
        <?php } ?>
        <table class="table table-striped table-hover table-bordered">
          <thead>
              <tr id='th'>
                <th> Area</th>
                <th> Name</th>
                <th> Quantity</th>
                <th> Action </th>
              </tr>
          </thead>
          <tbody>
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php $number = 1; ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <tr>
                    <td> <?php echo $number; ?></td>
                    <td> <?php echo $item['stock_name']; ?></td>
                    <td> <?php echo $item['stock_quantity']; ?></td>
                    <td> 
                      <a type="button" class="btn btn-info btn-sm" href='<?php echo Link::createUrl('Pages/Stocks/listing.php?name='.urlencode($item['stock_name']).'&type='.Constant::ITEM_MATERIAL); ?>'> View All <?php echo ucfirst($item['stock_name']); ?> Material</a> 
                    </td>
                  </tr>  
                <?php $number++; ?>
                <?php } ?>
            <?php } else { ?>
                  <tr>
                      <td colspan=7>
                          <div class="alert alert-info">
                              There are no items found.
                          </div>
                      </td>
                  </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php Template::footer(); ?>