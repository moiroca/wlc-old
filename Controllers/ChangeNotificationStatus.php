<?php
include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';

if (isset($_POST['notificationIds'])) {


	if (is_array($_POST['notificationIds'])) {
		$notificationService = new NotificationService();
		foreach ($_POST['notificationIds'] as $key => $notificationId) {
			$notificationService->updateNotificationToViewed((int)$notificationId);
		}		
	}
}

?>