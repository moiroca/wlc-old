<?php 

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();

$requisitions = new Requisitions();

$result = $requisitions->getAll(['*'], ['requester_id' => Login::getUserLoggedInId()]);

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
                  <i class="fa fa-table"></i>  <a href="#">My Requisition</a>
              </li>
          </ol>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        
        <table class="table table-striped table-hover table-bordered">
          <thead>
              <tr id='th'>
                  <th> Control Identifier </th>
                  <th> GSD Officer</th>
                  <th> President</th>
                  <th> Purpose </th>
                  <th> Status </th>
              </tr>
          </thead>
          <tbody>
              <?php $userObj = new User(); ?>
              <?php if ($result && 0 != $result->num_rows) { ?>
                  <?php  while ($item = $result->fetch_assoc()) { ?>
                    <tr>
                      <td> 
                          <a title="View Details Of Requisition" href="<?php echo Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$item['control_identifier']); ?>"><?php echo $item['control_identifier']; ?></a>
                      </td>
                      <td> 
                          <?php if ($item['gsd_officer_id']): ?>
                              <?php 
                                $user = $userObj->getAll(['*'], ['id' => $item['gsd_officer_id']])->fetch_assoc();
                                echo $user['lastname'].', '.$user['firstname'];
                              ?>
                          <?php else: ?>
                             <label class="label label-warning"> Not Yet Approved By GSD Officer</label>
                          <?php endif ?>
                      </td>
                      <td> 
                          <?php if ($item['president_id']): ?>
                              <?php
                                $user = $userObj->getAll(['*'], ['id' => $item['president_id']])->fetch_assoc();
                                echo $user['lastname'].', '.$user['firstname'];
                              ?>
                          <?php else: ?>
                             <label class="label label-warning"> Not Yet Approved By President</label>
                          <?php endif ?>
                      </td>
                      <td> <?php echo $item['purpose']; ?></td>
                      <td>
                          <?php if ($item['status'] == Constant::REQUISITION_APPROVED): ?>
                              <label class="label label-success"><?php echo $item['status']; ?></label>  
                          <?php elseif ($item['status'] == Constant::REQUISITION_DECLINED): ?>
                              <label class="label label-danger"><?php echo $item['status']; ?></label>  
                          <?php else: ?>
                              <label class="label label-info"><?php echo $item['status']; ?></label>  
                          <?php endif ?>
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
<?php Template::footer(['requisition.js', 'Requisition/requisition.js']); ?>