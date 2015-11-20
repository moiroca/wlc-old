<?php
session_start();
include_once("configure.php");
$name = mysql_real_escape_string($_POST['uname']);
$pass = mysql_real_escape_string($_POST['pword']);

	$result = mysql_query("SELECT * FROM user WHERE user_email = '".$_POST['uname']."' AND user_status = 'Active' AND user_pass= '".$_POST['pword']."' "); 
	
		if (mysql_num_rows($result)>0){ 
			while($row = mysql_fetch_array($result)){
				$usID = $row['user_id'];

						$query = "INSERT INTO logs(user_id,date,time) VALUES ('".$usID."', now(), now())";
		   			$result3 = mysql_query($query) or die ("Error in query:" .mysql_error());
						$resu = mysql_query("UPDATE user SET user_logs = now() WHERE user_email = '".$name."'");

								$_SESSION['login'] = "Admin";
								$_SESSION['user']= $uname;
								$_SESSION['last']= $row['user_lastname'];
								$_SESSION['first']= $row['user_firstname'];
								$_SESSION['mid']= $row['user_middle'];
								echo"<script>
								alert('Successfully Logged In as Administrator');
								
								</script>
								<meta http-equiv='refresh' content='0;url= ../homepage.php'>
								"; 	
			}
		}
		else{ 
			echo " <script> 
				alert('Failed to Login. Invalid Username and/or Password or Account has been deactivated! '); 
				</script> "; 
				echo"<meta http-equiv = 'refresh' content = '0; url = ../index.php'/>
			"; 
		} 
			
	
?>

