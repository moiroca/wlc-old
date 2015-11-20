<?php 
  include_once("../php/config.php");

// Check if delete button active, start this 

if(isset($_POST['delete']))
{
  
  $checkbox = $_POST['checkbox'];
  
  for($i=0;$i<count($checkbox);$i++)
  {
    mysql_query("Update area_dept set area_status = 'Deleted' where area_id = '".$checkbox[$i]."'") or die ("Error");
  }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=area_view.php\">";
}

if(isset($_POST['add']))
{
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=department_add.php\">";
}

?>