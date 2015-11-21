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

          					$iID=$_SESSION['itemID'];
                    $iid = mysql_real_escape_string($_POST['item_id']);
                    $iarea = mysql_real_escape_string($_POST['item_area']);
                    $idescr = mysql_real_escape_string($_POST['item_descr']);
                    $iquantity = mysql_real_escape_string($_POST['item_quantity']);
                    $istatus = mysql_real_escape_string($_POST['item_status']);
                    $iarea2 = $_SESSION['area_id'];

				//$search = $_SESSION['update'];
				//$update=$_POST['update'];

					
						if((int)$iid){
						mysql_query("Update Items SET item_id='".$iid."', item_area='".$iarea."',item_description='".$idescr."', item_quantity='".$iquantity."', item_status='".$istatus."', area_id='".$iarea2."' where item_id='".$iID."'");

    				echo"
    						<script>
    						alert('Record Successfully Updated!');
    						</script>
    						<meta http-equiv='refresh' content='0;url= allitems.php'>
    						";		
            }
						
						else{
						echo"<script>
							alert('Failed to update Item Record');
							</script>
							<meta http-equiv='refresh' content='0;url= item_update.php'>";
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
              <a href="sign-in.html" class="btn btn-primary">Yes</a>
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