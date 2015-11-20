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
        <li><a href="item_view.php?area_id=<?php echo $_SESSION['area_id'];?>">Manage Items</a></li>
        <li class="active">Update Item</li>
      </ol>

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
                    if(isset($_POST['update'])){
                      $checkbox = $_POST['checkbox'];
                        for($i=0;$i<count($checkbox);$i++){
                          $result=mysql_query("Select * from Items where item_id='".$checkbox[$i]."'") or die ("Error in Query");
                            if(mysql_num_rows($result)>0){
                              while($row =  mysql_fetch_array($result)){
                                $_SESSION['itemID'] = $row['item_id'];
  
                  ?> 
                  <fieldset>
                    <form action = "process_update.php" method="post">
                        <p><label for="item_id">Item ID:</label>
                        <input name="item_id" id="item_id" type="item_id" value="<?php echo $row['item_id'];?>" placeholder="item ID" required="required"/></p>
                        <p><label for="item_area">Area:</label>
                        <input name="item_area" id="item_area" type="text" value="<?php echo $row['item_area'];?>" placeholder="Description" required="required"/></p>
                        
                        <p><label for="item_descr">Description:</label>
                        <input name="item_descr" id="item_descr" type="text" value="<?php echo $row['item_description'];?>" placeholder="Description" required="required"/></p>
                        <p><label for="item_quantity">Quantity:</label>
                        <input name="item_quantity" id="item_quantity" type="item_quantity" value="<?php echo $row['item_quantity']; ?>" placeholder="Quantity" required="required"/></p>                    
                        
                        <p><label for="item_status">Status:</label>
                        <select name='item_status'>
                          <?php 
                          $quer=mysql_query('Select * from itemstatus where item_status!="Deleted"');
                            if(mysql_num_rows($quer)>0){
                              while($item_que =  mysql_fetch_array($quer)){
                          ?>
                              <option value='<? echo $item_que['item_status'] ?>' ><? echo $item_que['item_status'] ?><br /></option>
                          <?php
                              }
                            }
                          ?>
                      </select></p>
                      <p><input name="submit" style="margin-left: 150px;" class="formbutton" value="Save" type="submit" /></p>
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
      <footer class="templatemo-footer">
        <div class="templatemo-copyright">
          <p>Copyright &copy; Soria & Labra.  Credit: www.templatemo.com</p>
        </div>
      </footer>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/templatemo_script.js"></script>
  </body>
</html>