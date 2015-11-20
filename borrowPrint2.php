<?php
session_start();
  include_once("../php/configure.php");
  
  if(!isset($_SESSION['login'])){
    header("Location: index.php");
  }

  if($_SESSION['login'] == "Borrower"){
    $out = '<a href="php/logout.php"> Sign out </a>';
  }
  else if($_SESSION['login'] == "Admin"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "GSD Officer"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "Employee"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else if($_SESSION['login'] == "President"){
    $out = '<a href="php/logout.php"> Sign out </a>';  
  }
  else{
    $out = '<a href="index.php"> Sign out </a>';
  }

?>
<!DOCTYPE html>
  <head>
    <title>Borrowing Report</title>
    <link href="css/report.css" rel="stylesheet" type="text/css" />
  </head>
  <script language="javascript">
    function docprint()
    { 
      var disp_setting="toolbar=no,location=no,directories=no,menubar=no, scrollbars=yes,width=1000, height=600, left=100, top=25"; 
      var content_vlue = document.getElementById("container").innerHTML; 
      
       var docprint=window.open("","",disp_setting);
       docprint.document.open(); 
       docprint.document.write('<html><head><title></title><style>table, td, th{border-collapse: collapse;border: 2px solid gray;padding:5px;margin:10px;text-align:center;}</style><body onLoad="self.print()" style="width: 100%; font-size:12px; font-family:arial;">');          
       docprint.document.write(content_vlue);          
       docprint.document.write('</body></html>'); 
       docprint.document.close(); 
       docprint.focus();
    }
  </script>
<body >
  <center><input type="button" onClick=location.href="javascript:docprint()" value="Print"></center>
  <div id="container">
    
    <div id="print_content">
    
      <?php
        include ('header.php');
        include ('borrowPrint.php');
        include ('footer.php');
      ?>
    </div>
  </div>
</body>