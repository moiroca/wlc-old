<?php
session_start();
  include_once("../php/config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
  <link rel="stylesheet" href="../css/templatemo_main.css">
  <script language="javascript" src="../javascript/confirm.js" type="text/javascript"></script>
</head>
<body>
  <?php include("../includes/header2.php");?>

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li class="active">Add Department/Area</li>
            <li><a href="area_view.php">Manage Department/Area</a></li>
          </ol>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive" >
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">Add Record For Department/Area</h4>
                    </div>
                    <div class="panel-body">
                      <fieldset>
                        <form action = "area_add.php" method="post">
                        
                          <p><label for="areaName">Description:</label>
                          <input name="areaName" id="areaName" type="text" placeholder="Description" required="required"/></p>
                          <p><label for="deptDean">Department Dean/ Area In-Charge:</label>
                          <input name="deptDean" id="deptDean" type="text" placeholder="Mr./Ms. Complete Name, Post-Nominals (ex. Mr. Juan De la Cruz, RN)" required="required"/></p>
                          
                          <p><input name="submit" style="margin-left: 150px;" class="formbutton" value="Add" type="submit" /></p>
                        </form>
                      </fieldset>
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
          <p>Copyright &copy; Soria and Labra. Credits to: <a href="www.templatemo.com">Templatemo-adminpanel/dashboard</a></p>
        </div>
      </footer>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>