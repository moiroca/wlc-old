<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

Login::sessionStart();
if (!Login::isLoggedIn()) { Login::redirectToLogin(); }

$notificationsObj = new Notification();

$notifications = $notificationsObj->getAllBySenderId((int)Login::getUserLoggedInId());

?>
<?php Template::header(); ?>
<div class="row">
  <div class="col-lg-12">
      <h1 class="page-header">Notifications</h1>
      <ol class="breadcrumb">
          <li>
              <i class="fa fa-dashboard"></i>  <a href="#">Notifications</a>
          </li>
      </ol>
  </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<table class="table table-hover table-striped">
	        <thead>
	            <tr>
	                <th>Notifications</th>
	                <th>Sender Name</th>
	                <th>Date Time</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php if ($notifications->num_rows != 0): ?>
	        		<?php while($notification = $notifications->fetch_assoc()): ?>
		        		<tr>
		        			<td><?php echo $notification['notification_msg'] ?> </td>
		        			<td><?php echo RequesterUtility::getFullName($notification); ?> </td>
		        			<td><?php echo $notification['notification_datetime_sent'] ?> </td>
		        		</tr>
		        	<?php endwhile; ?>
	        	<?php else : ?>
	        		<tr>
	        			<td colspan=2> 
	        				<div class="alert alert-info">
	        					There is no notifications found.
	        				</div>
	        			</td>
	        		</tr>
	        	<?php endif; ?>
	        </tbody>
	    </table>
	</div>
</div>
<?php Template::footer(); ?>