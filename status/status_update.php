<?php
session_start();
  include_once("../php/configure.php");
  
  if(!isset($_SESSION['login'])){
    header("Location: index.php");
  }

  if($_SESSION['login'] == "Borrower"){
    $out = '<a href="../php/configure.php"> Sign out </a>';
  }
  else if($_SESSION['login'] == "Admin"){
    $out = '<a href="../php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "GSD Officer"){
    $out = '<a href="../php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "Employee"){
    $out = '<a href="../php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "President"){
    $out = '<a href="../php/logout.php"> Sign out </a>';  
  }
  else{
    $out = '<a href="../index.php"> Sign out </a>';
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
  <link rel="stylesheet" href="../css/templatemo_main.css">
  <script language="javascript" src="../javascript/confirm.js" type="text/javascript"></script>

</head>
<body>
  <div id="main-wrapper">
    <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
       <div class="logo"><h1>WLC FACILITIES AND EQUIPMENTS - Inventory and Monitoring System</h1></div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button> 
      </div>   
    </div>
    <div class="template-page-wrapper">
      <div class="navbar-collapse collapse templatemo-sidebar">
        <ul class="templatemo-sidebar-menu">
          <li>
            <form class="navbar-form">
              <input type="text" class="form-control" id="templatemo_search_box" placeholder="Search...">
              <span class="btn btn-default">Go</span>
            </form>
          </li>
          <li><a href="../home.php"><i class="fa fa-home"></i>Home</a></li>
          <li class="sub">
           <a href="javascript:;">
              <i class="fa fa-envelope"></i> Report <div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li><a href="#">Equipments</a></li>
              <li><a href="#">Tools</a></li>
              <li><a href="#">Materials</a></li> 
              <li><a href="#">Department</a></li>
              <li><a href="#">Borrower</a></li>
              <li><a href="#">Reservation</a></li> 
            </ul>
          </li>
           <li class="sub">
            <a href="javascript:;">
              <i class="fa fa-folder"></i> Manage Records <div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li><a href="items/item_view.php"><i class="fa fa-file"></i> Items</a></li> 
              <li><a href="employees/employee_view.php"><i class="fa fa-file"></i> Employees</a></li>
              <li><a href="department/area_view.php"><i class="fa fa-file"></i> Department</a></li> 
            </ul>
          </li>
          
          <li class="sub">
            <a href="javascript:;">
              <i class="fa fa-th-list"></i> Manage Status <div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li><a href="../status/status_view.php"><i class="fa fa-th-large"></i> Item Status</a></li> 
              <li><a href="../status/status_availview.php"><i class="fa fa-th-large"></i> Item Availability</a></li>
              <li><a href="../status/status_approvalview.php"><i class="fa fa-th-large"></i> Approval</a></li> 
            </ul>
          </li>
          
          <li><a href="#"><i class="fa fa-cubes"></i><span class="badge pull-right">View</span>Borrow</a></li> 
          <li><a href="#"><i class="fa fa-cubes"></i><span class="badge pull-right">View</span>Reservations</a></li>          
          <li><a href="../user/account_view.php"><i class="fa fa-users"></i><span class="badge pull-right">View</span>Manage Users</a></li>
          <li><a href="status_view.php"><i class="fa fa-cog"></i><span class="badge pull-right">View</span>Manage Item Status</a></li>
          <li><?php echo $out?></li>
        </ul>
      </div><!--/.navbar-collapse -->

      
      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li><a href="status_view.php">Manage Item status</a></li>
            <li class="active">Update Item Status</li>
          </ol>

          <div class="row">
            <div class="col-md-12">
              
              <div class="table-responsive" >
                
                
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Update Item Status</h4>
                  </div>
                  <div class="panel-body">
                     <?php

    $con=mysql_connect("localhost","root","");
    
    mysql_select_db("inventory");
    
            if(isset($_POST['update']))
            {
            
                $checkbox = $_POST['checkbox'];
                
                    for($i=0;$i<count($checkbox);$i++)
                    {
                    $result=mysql_query("Select * from itemstatus where status_id='".$checkbox[$i]."'") or die ("Error in Query");
                        
                        if(mysql_num_rows($result)>0)
                        {
                            while($row =  mysql_fetch_array($result))
                            
                            { $_SESSION['stat_id'] = $row['status_id'];
    
?> 
            <fieldset>
                <form action = "process_statusupdate.php" method="post">
                    
                    <p><label for="item_status">Description:</label>
                    <input name="item_status" id="item_status" type="text" value="<?php echo $row['item_status'];?>" placeholder="Description" required="required"/></p>
                  
                    <a href='#' >
                    <input class='butt' type='submit' value='Save' name='save'></p>
                </form>
            </fieldset>
    <?php
                    }
                }
            }
        }
    ?>
                  </div>
                </div>                
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
              <a href="../index.php" class="btn btn-primary">Yes</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>

      <footer class="templatemo-footer">
        <div class="templatemo-copyright">
          <p>Copyright &copy; Soria & Labra.  Credit: www.templatemo.com</p>
        </div>
      </footer>
    </div>
</div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>