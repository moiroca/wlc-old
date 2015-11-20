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
  <?php include("includes/header.php");?>
    <div class="templatemo-content-wrapper">
      <div class="templatemo-content">
        <h1>Western Leyte College of Ormoc, Inc.</h1>
        <p>Facilities, Tools, Materials and Equipments are monitored. To keep track about their availability and status/conditions.</p>
        <div class="margin-bottom-30">
         <div class="row">
          <div class="row">
            <div class="col-md-6 col-sm-6">         

                <table class="table table-striped table-hover table-bordered">
                  <thead>
                    <form name="actionDepartment" method="post" action="">
                      <?php
                        $result = mysql_query("SELECT * FROM Area ");
                          if(mysql_num_rows($result) > 0){
                            echo "<tr id='th'>
                                  <th> Department ID</th>
                                  <th> Description</th>
                            </tr>"; ?>
                  </thead>
                  <tbody>
                    <?php while($row = mysql_fetch_array($result)){ ?>      
                      <tr>
                        <td> <?php echo $row['area_id']; ?></td>
                        <td> <?php echo $row['area_name'] ?></td>
                      </tr>           
                      <?php }
                          echo "</table>";  
                        }
                      ?>                
                  </tbody>
                </table>
                  
              
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