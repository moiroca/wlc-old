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
      <ul class="templatemo-sidebar-menu"><br>
        
        <li class="active"><a href="<?php echo Link::createUrl('Pages/home.php'); ?>"><i class="fa fa-home"></i>Home</a></li><br>
        
        <?php if (Login::getLoggedInType() == CONSTANT::USER_ADMIN) { ?>
          <li><a href="<?php echo Link::createUrl('Controllers/logout.php'); ?>"> Sign out </a></li> 
        <?php } ?>
      </ul>
    </div><!--/.navbar-collapse -->