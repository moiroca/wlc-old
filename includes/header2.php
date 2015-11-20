<?php
session_start();
  include_once("../php/config2.php");
  
?>

<div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1>WLC FACILITIES AND EQUIPMENT - Inventory and Monitoring System</h1></div>
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
          <!--<li>
            <form class="navbar-form">
              <input type="text" class="form-control" id="templatemo_search_box" placeholder="Search...">
              <span class="btn btn-default">Go</span>
            </form>
          </li>-->
          <li class="active"><a href="../homepage.php"><i class="fa fa-home"></i>Home</a></li>
          
                    
          <li><a href="../user/account_view.php"><i class="fa fa-users"></i><span class="badge pull-right">View</span>Manage Account</a></li>
          <li><?php echo $out?></li>
        </ul>
      </div><!--/.navbar-collapse -->