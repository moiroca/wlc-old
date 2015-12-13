<?php

include $_SERVER['DOCUMENT_ROOT'].'/Core/Loader.php';
Login::sessionStart();

$requisitionId = isset($_POST['requisitionId']) ? $_POST['requisitionId'] : null;

if ($requisitionId) {
	$requsitionRepo = new Requisitions();
	$requisition = $requsitionRepo->getAll(null, ['id' => (int)$requisitionId]);

	$control_identifier = $requisition->fetch_assoc()['control_identifier'];

	if (Login::getUserLoggedInType() == Constant::USER_PRESIDENT) {

		$requsitionRepo->update([
			'datetime_approveddeclined_by_president' => date_create()->format('Y-m-d H:i:s'),
			'president_id' => Login::getUserLoggedInId(),
			'status' => Constant::REQUISITION_DECLINED
		], ['id' => (int)$requisitionId]);	
	} else if (Login::getUserLoggedInType() == Constant::USER_GSD_OFFICER) {

		$requsitionRepo->update([
			'datetime_approveddeclined_by_gsd_officer' => date_create()->format('Y-m-d H:i:s'),
			'gsd_officer_id' => Login::getUserLoggedInId(),
			'status' => Constant::REQUISITION_DECLINED
		], ['id' => (int)$requisitionId]);	
	}

	// header('location: '.Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$control_identifier));
	echo Link::createUrl('Pages/Requisitions/requisition.php?control_identifier='.$control_identifier);
}