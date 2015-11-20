<?php if($_POST['submit']){
  include_once("../php/config.php");
  //$area_id = mysql_real_escape_string($_POST['area_id']);
  $area_description = mysql_real_escape_string($_POST['areaName']);
  $area_dean = mysql_real_escape_string($_POST['deptDean']);

  $que = "Select area_name from area_dept where area_name='".$area_description."' ";
  $res = mysql_query($que) or die("Error");
    
    if(mysql_num_rows($res)){
      echo"
        <script>
          alert('Department already exist!');
        </script>
        <meta http-equiv='refresh' content='0;url=department_add.php'>
      ";
    }
    else{
      
      $query = "INSERT INTO area_dept(area_name,dept_dean, area_status) VALUES ('".$area_description . "','" . $area_dean . "','Displayed')";
      $result = mysql_query($query) or die ("Error in query:" .mysql_error());
      /*echo"
        <script>
          alert('".$area_description."','" .$area_dean."');
        </script>";*/
      echo"
        <script>
          alert('Record Successfully Added!');
        </script>
        <meta http-equiv='refresh' content='0;url= area_view.php'>
      ";
    }
}

?>