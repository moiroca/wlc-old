<?php
	include_once("../php/config.php");

	$area_id=$_SESSION['area_id'];
	$area_name= mysql_real_escape_string($_POST['areaName']);
	$dept_dean= mysql_real_escape_string($_POST['deptDean']);
	
	if((int)$area_id){
		mysql_query("Update area_dept SET area_name='".$area_name."', dept_dean='".$dept_dean."' where area_id='".$area_id."'");

    echo"
  		<script>
  		alert('Record Successfully Updated!');
  		</script>
  		<meta http-equiv='refresh' content='0;url= area_view.php'>
  	";		
  }
		
		else{
		echo"<script>
			alert('Failed to update this record!');
			</script>
			<meta http-equiv='refresh' content='0;url= department_update.php'>";
		}

?>