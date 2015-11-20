<?php
session_start();
  include_once("configure.php");
  
  if(!isset($_SESSION['login'])){
    header("Location: index.php");
  }

  if($_SESSION['login'] == "Admin"){
    $out = '<a href="../php/logout.php"> Sign out </a>';  
  }
  
  else{
    $out = '<a href="../index.php"> Sign out </a>';
  }

?>