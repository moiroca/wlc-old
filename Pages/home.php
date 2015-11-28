<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

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