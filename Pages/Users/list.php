<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$userObj = new User();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

?>
<?php Template::header(); ?>
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Presidents</h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="#">User Accounts</a>
              </li>
              <li class='active'>
                  <i class="fa fa-table"></i>  <a href="#">Users</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">

        <?php 

            $result = $userObj->getAll([
                'id',
                'email',
                'firstname as user_firstname',
                'middlename',
                'lastname as user_lastname',
                'status',
                'datetime_added',
                'type'
              ], []);
        ?>

        <?php if (isset($_SESSION['record_successful_added'])) { ?>
        <?php unset($_SESSION['record_successful_added']); ?>
            <div class="alert alert-success">
                New User Added.
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
                <th> Type </th>
                <th> Full Name </th>
                <th> Username </th>
                <th> Status </th>
                <th> Datetime Registered </th>
                <th> Action </th>
              </tr>
          </thead>
          <tbody>
            <?php if ($result && 0 != $result->num_rows) { ?>
                <?php  while ($user = $result->fetch_assoc()) { ?>
                  <?php if ($user['type'] != Constant::USER_INVENTORY_OFFICER): ?>
                    <tr>
                      <td><?php echo $user['type']; ?></td>
                      <td><?php echo RequesterUtility::getFullName($user); ?></td>
                      <td><?php echo $user['email']; ?></td>
                      <td><?php echo UserUtility::formatStatus($user['status']); ?></td>
                      <td><?php echo $user['datetime_added']; ?></td>
                      <td>
                          <a href="<?php echo Link::createUrl('Pages/Users/update.php?user='.$user['id']); ?>" class='btn btn-sm btn-primary'>
                            <i class='fa fa-pencil'> Edit</i>
                          </a>
                          <a href="#" class='btn btn-sm btn-warning'>
                            <i class='fa fa-delete'>Delete</i>
                          </a>
                      </td>
                    </tr>  
                  <?php endif ?>
                <?php } ?>
            <?php } else { ?>
                  <tr>
                      <td colspan=5>
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