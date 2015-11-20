<?php
session_start();
include_once("php/config.php");
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
  <link rel="stylesheet" href="css/templatemo_main.css">
  <script language="javascript" src="../javascript/confirm.js" type="text/javascript"></script>
</head>
<body>
  <?php include("includes/header4.php");?>
    <div class="templatemo-content-wrapper">
      <div class="templatemo-content">
        <h1>Western Leyte College of Ormoc, Inc.</h1>
        <p>Facilities, Tools, Materials and Equipments are monitored. To keep track about their availability and status/conditions.</p>
        <div class="margin-bottom-30">
         <div class="row">       

              <div class="row">
              <div class="col-md-6 col-sm-6">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist" id="templatemo-tabs">
                  <li class="active"><a href="#file" role="tab" data-toggle="tab">File</a></li>
                  <li><a href="#transaction" role="tab" data-toggle="tab">Transaction</a></li>
                  <li><a href="#inquiries" role="tab" data-toggle="tab">Inquiries</a></li>
                  <li><a href="#reports" role="tab" data-toggle="tab">Reports</a></li>
                  <li><a href="#utilities" role="tab" data-toggle="tab">Utilities</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="file">
                    <center>
                      <a href="items/allitems.php" class="list-group-item"> Item </a>
                      <!--<a href="#" class="list-group-item"> Category </a> -->
                      <a href="department/alldepartment.php" class="list-group-item"> Department </a>
                    </center>
                  </div>
                  <div class="tab-pane fade" id="transaction">
                    <center>
                      <!--<a href="department/area_view.php" class="list-group-item"> Add Inventory Report </a>-->
                      <a href="department/area_view.php" class="list-group-item"> Requisition For Repair </a>
                      <a href="department/area_view_replace.php" class="list-group-item"> Requisition For Replacement</a>
                      <a href="newstocks/group_add.php" class="list-group-item"> New Stocks </a>
                      <a href="newstocks/equipment_add.php" class="list-group-item"> Add New Equipment </a>
                    </center>
                  </div>

                  <div class="tab-pane fade" id="inquiries">
                    <div class="list-group">
                    <center>
                     <a href="inquiries/inquire_item.php" class="list-group-item"> Items </a>
                     <a href="inquiries/inquire_dept.php" class="list-group-item"> Department </a>
                     <!--<a href="#" class="list-group-item"> New Stocks </a>
                    --></center>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="reports">
                    <div class="list-group">
                    <center>
                      <a href="addreport/report_view.php" class="list-group-item"> Department</a>
                      <a href="#" class="list-group-item">For Repair </a>
                      <a href="#" class="list-group-item">For Replacement </a>
                      <a href="#" class="list-group-item">New Stocks </a>
                      <a href="#" class="list-group-item">All Reports </a>
                    </center>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="utilities">
                    <div class="list-group">
                    <center>
                      <a href="#" class="list-group-item"> User Settings </a>
                      <!--<a href="#" class="list-group-item"> User Settings </a>-->
                      <a href="user/account_view.php" class="list-group-item"> User Maintenance </a>
                    </center>
                    </div>
                  </div>
                </div> <!-- tab-content --> 
              </div> 
                        
            </div>
                  
              
          </div>
        </div>
      </div> 
    </div> 
    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Are you sure you want to sign out?</h4>
          </div>
          <div class="modal-footer">
            <a href="php/logout.php" class="btn btn-primary">Yes</a>
            
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
    <footer class="templatemo-footer">
      <div class="templatemo-copyright">
        <p>Copyright &copy; Soria and Labra. Credits to: <a href="www.templatemo.com">Templatemo-adminpanel/dashboard</a></p>
      </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/templatemo_script.js"></script>
    <script type="text/javascript">
    
    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    $('#loading-example-btn').click(function () {
      var btn = $(this);
      btn.button('loading');
      // $.ajax(...).always(function () {
      //   btn.button('reset');
      // });
  });
  </script>
</body>
</html>