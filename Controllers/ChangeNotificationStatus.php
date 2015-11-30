<?php
include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

if (isset($_POST['notificationIds'])) {

	$notificationService = new NotificationService();

	if (is_array($_POST['notificationIds'])) {
		foreach ($_POST['notificationIds'] as $key => $notificationId) {
			$notificationService->updateNotificationToViewed((int)$notificationId);
		}		
	}
}

?>