<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
Login::destroySession();
Login::redirectToLogin();

?>
