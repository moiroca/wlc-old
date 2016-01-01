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
                  <th> Noted By Department Head</th>
                  <th> Type</th>
                  <th> Comptroller</th>
                  <th> President</th>
                  <th> Purpose </th>
                  <th> Status </th>
              </tr>
          </thead>
          <tbody>
              <?php $userObj = new User(); ?>
              <?php if ($result && 0 != $result->num_rows) { ?>
                  <?php $ind = 0; $firstItem = ''; ?>
                  <?php  while ($item = $result->fetch_assoc()) { ?>
                    <?php if (0 == $ind): ?>
                        <?php $stocksRepo = new Stocks(); ?>
                        <?php $itemsInRequisition = $stocksRepo->getStockByRequisitionId($item['id']); ?>
                        <?php $firstItem = $itemsInRequisition->fetch_assoc(); ?>
                    <?php endif ?>
                    <tr>
                      <td> 
                          <a title="View Details Of Requisition" href="<?php echo Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$item['control_identifier']); ?>"><?php echo $item['control_identifier']; ?></a>
                      </td>
                      <td>
                          <?php if ($item['department_head_id']): ?>
                              <?php
                                $user = $userObj->getAll(['*'], ['id' => $item['department_head_id']])->fetch_assoc();
                                echo $user['lastname'].', '.$user['firstname'];
                              ?>
                          <?php else: ?>
                             <label class="label label-warning"> Not Yet Noted By Department Head</label>
                          <?php endif ?>
                      </td>
                      <td> 
                          <?php if ($firstItem && $firstItem['stock_type'] == Constant::ITEM_MATERIAL_EQUIPMENT): ?>
                              <?php if ($item['gsd_officer_id']): ?>
                                  <?php 
                                    $user = $userObj->getAll(['*'], ['id' => $item['gsd_officer_id']])->fetch_assoc();
                                    echo '<b>GSD Officer: </b>'.$user['lastname'].', '.$user['firstname'];
                                  ?>
                              <?php else: ?>
                                 <label class="label label-warning"> Not Yet Approved By GSD Officer</label>
                              <?php endif ?>
                          <?php else: ?>
                              <?php if ($item['property_custodian_id']): ?>
                                  <?php 
                                    $user = $userObj->getAll(['*'], ['id' => $item['property_custodian_id']])->fetch_assoc();
                                    echo '<b>Property Custodian: </b>'. $user['lastname'].', '.$user['firstname'];
                                  ?>
                              <?php else: ?>
                                 <label class="label label-warning"> Not Yet Verified By Property Custodian</label>
                              <?php endif ?>
                          <?php endif ?>
                      </td>
                      <td>
                          <?php if ($item['comptroller_id']): ?>
                              <?php
                                $user = $userObj->getAll(['*'], ['id' => $item['comptroller_id']])->fetch_assoc();
                                echo $user['lastname'].', '.$user['firstname'];
                              ?>
                          <?php else: ?>
                             <label class="label label-warning"> Not Yet Approved By Comptroller</label>
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
                          <?php 

                            $item['stock_type'] = isset($firstItem['stock_type']) ? $firstItem['stock_type'] : ''; 
                            
                            if (RequisitionUtility::isRequisitionApproved($item)) {
                          ?>
                            <label class="label label-success"><?php echo $item['status']; ?></label>
                          <?php  
                            } else {
                          ?>
                            <label class="label label-warning"><?php echo $item['status']; ?></label>  
                          <?php
                            }
                          ?>
                      </td>
                    </tr>  
                    <?php $ind++; ?>
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