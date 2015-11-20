<?php 
  include_once("../php/config.php");
  // Check if delete button active, start this 

  if(isset($_POST['delete'])){
    $checkbox = $_POST['checkbox'];
    for($i=0;$i<count($checkbox);$i++){
      mysql_query("Update User set user_status = 'Deleted' where user_id = '".$checkbox[$i]."'") or die ("Error");
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=account_view.php\">";
  }
  
  if(isset($_POST['add'])){
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=account_add.php\">";
  }
  
?>