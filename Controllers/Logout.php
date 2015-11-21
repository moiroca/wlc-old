<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';

Login::sessionStart();
Login::destroySession();
Login::redirectToLogin();

?>
