<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

?>

<?php Template::header(); ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
</div>
<div class="row">
  <div class="col-lg-12">
      
  </div>
</div>
<?php Template::footer(); ?>