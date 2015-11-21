<?php

include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Log.php';

$db = DbConnection::connect()->getConnection(); 
Login::sessionStart();

if (Login::checkIfUsernamePasswordSet()) {

	$username = $db->real_escape_string($_POST['username']);
	$password = $db->real_escape_string($_POST['password']);
} else {
	Login::redirectToLogin();
}

$result = $db->query("SELECT * FROM user WHERE user_email = '".$username."' AND user_status = 'Active' AND user_pass= '".$password."' "); 

if ($user = $result->fetch_assoc()){ 

	Log::saveLogin($db, $row['user_id']);
	Log::updateUserLog($db, $user['user_email']);

	$_SESSION['login'] 	= Constant::USER_ADMIN;
	$_SESSION['user']	= $user['user_email'];
	$_SESSION['last']	= $user['user_lastname'];
	$_SESSION['first']	= $user['user_firstname'];
	$_SESSION['mid']	= $user['user_middle'];

	Login::redirectToHome();

} else { 

	Login::setIsLoginError();
	Login::redirectToLogin();
} 

