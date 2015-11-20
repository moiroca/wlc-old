<?php
session_start();
  include_once("../php/configure.php");
  
  if($_SESSION['login'] == "Borrower"){
    $out = '<a href="../php/logout.php"> Logout </a>';
  }
  else if($_SESSION['login'] == "Admin"){
    $out = '<a href="../php/logout.php"> Logout </a>';  
  }
  else if($_SESSION['login'] == "GSD Officer"){
    $out = '<a href="../php/logout.php"> Logout </a>';  
  }
  else if($_SESSION['login'] == "Employee"){
    $out = '<a href="../php/logout.php"> Logout </a>';  
  }
  else if($_SESSION['login'] == "President"){
    $out = '<a href="../php/logout.php"> Logout </a>';  
  }
  else{
    $out = '<a href="../index.php"> Logout </a>';
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
              <i class="fa fa-database"></i> Report <div class="pull-right"><span class="caret"></span></div>
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
              <i class="fa fa-database"></i> Manage Records <div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li><a href="item_view.php"><i class="fa fa-cubes"></i><span class="badge pull-right">View</span>Items</a></li> 
              <li><a href="../employees/employee_add.php">Employees</a></li>
              <li><a href="../department/department_add.php">Department</a></li> 
            </ul>
          </li>
          
          <li><a href="#"><i class="fa fa-cubes"></i><span class="badge pull-right">View</span>Borrow</a></li> 
          <li><a href="#"><i class="fa fa-cubes"></i><span class="badge pull-right">View</span>Reservations</a></li>          
          <li><a href="../user/account_view.php"><i class="fa fa-users"></i><span class="badge pull-right">View</span>Manage Users</a></li>
          <li><?php echo $out?></li>
        </ul>
      </div><!--/.navbar-collapse -->

      
      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li><a href="item_view.php">Manage Item</a></li>
            <li class="active">Update Item</li>
          </ol>
          <h1>Manage Users</h1>

          <div class="row">
            <div class="col-md-12">
              
              <div class="table-responsive" >
                
                
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Update Item</h4>
                  </div>
                  <div class="panel-body">
                    <?php 

					$con=mysql_connect("localhost","root","");
					
					mysql_select_db("inventory");
           
          $idstat=$_SESSION['stat_id'];
					$istatus=$_POST['item_status'];

						
						
            $que = "Select * from itemstatus where item_status='".$istatus."'";
            $res = mysql_query($que) or die("YEHET");
            if(mysql_num_rows($res)){
						echo"<script>
							alert('Already Exist.');
							</script>
							<meta http-equiv='refresh' content='0;url= status_update.php'>";
						}
            else{
              mysql_query("Update itemstatus SET item_status='".$istatus."' where status_id='".$idstat."' ");

        echo"
            <script>
            alert('Record Successfully Updated!');
            </script>
            <meta http-equiv='refresh' content='0;url= status_view.php'>
            ";    
            
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