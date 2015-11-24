<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Requisitions.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

include $_SERVER['DOCUMENT_ROOT'].'/Utilities/RequesterUtility.php';

Login::sessionStart();

$requisitions = new Requisitions();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Requisitions</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">Requisitions</a>
              </li>
              <li class='active'>
                  <i class="fa fa-table"></i>  <a href="#">Job Requisition</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">

        <?php 

            $result = $requisitions->getAllRequesition(Constant::REQUISITION_JOB);
        ?>

        <?php if (isset($_SESSION['record_successful_added'])) { ?>
        <?php unset($_SESSION['record_successful_added']); ?>
            <div class="alert alert-success">
                Item Requisition Record Succesfully Added.
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
                <th> View Items </th>
                <th> Control Identifier </th>
                <th> Requester Name </th>
                <th> Purpose </th>
                <th> Date and Time Added </th>
                <th> Date and Time Approved </th>
                <th> Status </th>
              </tr>
          </thead>
          <tbody>
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php  while ($item = $result->fetch_assoc()) { ?>
                  <tr>
                    <td> 
                      <?php if ($item['requisition_status'] == Constant::REQUISITION_APPROVED ) { ?>
                        <a 
                          class='btn btn-success btn-sm' 
                          href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php?control_identifier='.$item['requisition_control_identifier']); ?>">
                          <i class='fa fa-table'></i> View Items
                        </a> 
                      <?php } else { ?> 
                        <i class='label label-info'>Items Not Available</i> 
                      <?php } ?>
                    </td>
                    <td> <?php echo $item['requisition_control_identifier']; ?></td>
                    <td> <?php echo RequesterUtility::getFullName($item); ?></td>
                    <td> <?php echo $item['requisition_purpose']; ?></td>
                    <td> <?php echo $item['requisition_datetime_added']; ?></td>
                    <td>
                        <?php if ($item['requisition_datetime_provided']) { ?>
                            <?php echo $item['requisition_datetime_provided']; ?>
                        <?php } else { ?>
                            <i class='label label-info'>Datetime not available</i>
                        <?php } ?>
                    </td>
                    <td> 
                      <?php if ($item['requisition_status'] == Constant::REQUISITION_APPROVED) { ?> 
                        <i class='label label-success'><?php echo $item['requisition_status']; ?></i>
                      <?php } else { ?> 
                        <i class='label label-info'><?php echo $item['requisition_status']; ?></i>
                      <?php } ?>
                    </td>
                  </tr>  
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