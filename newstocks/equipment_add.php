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
  <?php include("../includes/header5.php");?>

      
      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
          <h6>In this section, every equipment will have a generated ID for specific purposes.</h6>
          </ol>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <div class="col-md-6 col-sm-6 margin-bottom-30">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">Add Equipment</h4>
                  </div>
                  <div class="panel-body">
                    <fieldset>
                        <form action = "equipmentprocess_add.php" method="post">
                            <p><label for="item_id">Equipment ID:</label>
                            <input name="item_id" id="item_id" type="item_id" placeholder="Equipment ID" required="required"/></p>
                            <p>Area/Department: 
                            <select name='area_id'>
                            <?php 
                            $areaquery=mysql_query('Select * from area_dept where area_status!="Deleted"');
                                
                                if(mysql_num_rows($areaquery)>0)
                                    {
                                        while($area_status =  mysql_fetch_array($areaquery))
                                        
                                        {
                            ?>
                                            <option value='<? echo $area_status['area_id'] ?>' ><? echo $area_status['area_name'] ?><br /></option>
                            <?php
                                        }
                                    } 
                            ?>
                        </select></p>
                            <p><label for="item_area">Room Area:</label>
                            <input name="item_area" id="item_area" type="text" placeholder="Room Area" required="required"/></p>
                            
                            <p><label for="item_descr">Description:</label>
                            <input name="item_descr" id="item_descr" type="text" placeholder="Description" required="required"/></p>
                            <p><label for="item_quantity">Quantity:</label>
                            <input name="item_quantity" id="item_quantity" type="text" placeholder="Quantity" required="required"/></p>
                            
                            
                            <p><label for="item_status">Status:</label>
                           <select name='item_status'>
                            <?php 
                            $itemquery=mysql_query('Select * from itemstatus where item_status!="Deleted"');
                                
                                if(mysql_num_rows($itemquery)>0)
                                    {
                                        while($itemstatus =  mysql_fetch_array($itemquery))
                                        
                                        {
                            ?>
                                            <option value='<? echo $itemstatus['item_status'] ?>' ><? echo $itemstatus['item_status'] ?><br /></option>
                            <?php
                                        }
                                    } 
                            ?>
                        </select></p>

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