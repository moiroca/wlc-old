<?php

/* Load All Utilities */
include $_SERVER['DOCUMENT_ROOT'].'/Utilities/Constant.php';
include $_SERVER['DOCUMENT_ROOT'].'/Utilities/StockUtility.php';
include $_SERVER['DOCUMENT_ROOT'].'/Utilities/UserUtility.php';
include $_SERVER['DOCUMENT_ROOT'].'/Utilities/RequesterUtility.php';
include $_SERVER['DOCUMENT_ROOT'].'/Utilities/RequisitionUtility.php';

/* Load All Core */
include $_SERVER['DOCUMENT_ROOT'].'/Config/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Login.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Log.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Assets.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/LoggedInUser.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Template.php';
include $_SERVER['DOCUMENT_ROOT'].'/Core/Link.php';

/* Load All Repo */
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Requisitions.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Department.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Stocks.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/User.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Tools.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Area.php';
include $_SERVER['DOCUMENT_ROOT'].'/Repositories/ItemRequisition.php';

/* Load All Services */
include $_SERVER['DOCUMENT_ROOT'].'/Services/AreaService.php';
include $_SERVER['DOCUMENT_ROOT'].'/Services/DepartmentService.php';
include $_SERVER['DOCUMENT_ROOT'].'/Services/StockService.php';
include $_SERVER['DOCUMENT_ROOT'].'/Services/RequisitionService.php';
include $_SERVER['DOCUMENT_ROOT'].'/Services/UserService.php';

?>
