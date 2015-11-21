<?php 
  include_once("../php/config.php");
  
// Check if delete button active, start this 

  if(isset($_POST['delete']))
  {
    
    $checkbox = $_POST['checkbox'];
    
    for($i=0;$i<count($checkbox);$i++)
    {
      mysql_query("Update Items set item_status = 'Deleted' where item_id = '".$checkbox[$i]."'") or die ("Error");
    }
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=item_view.php\">";
  }
  
  if(isset($_POST['add']))
  {
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=item_add.php\">";
  }
                          
?>