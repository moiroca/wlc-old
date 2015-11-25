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

$result = $db->query("SELECT * FROM users WHERE email = '".$username."' AND status = 'Active' AND password = '".$password."' "); 

if ($user = $result->fetch_assoc()){ 

	Log::saveLogin($db, $user['id']);
	Log::updateUserLog($db, $user['email']);

	$_SESSION['id']			= $user['id'];
	$_SESSION['type'] 		= $user['type'];
	$_SESSION['email']		= $user['email'];
	$_SESSION['lastname']	= $user['lastname'];
	$_SESSION['firstname']	= $user['firstname'];
	$_SESSION['middlename']	= $user['middlename'];

	Login::redirectToHome();

} else { 

	Login::setIsLoginError();
	Login::redirectToLogin();
} 

