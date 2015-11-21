function setDeleteActionDept(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionDepartment.action="department_delete.php";
	document.actionDepartment.submit();
	}
}

function setUpdateActionDept() {
	document.actionDepartment.action="department_update.php";
	document.actionDepartment.submit();
}

function setDeleteActionUser(){
	if(confirm("Are you sure you want to delete this record?")){
	document.useraccount.action="account_delete.php";
	document.useraccount.submit();
	}
}

function setUpdateActionUser() {
	document.useraccount.action="account_update.php";
	document.useraccount.submit();
}




function setDeleteActionItem(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionItem.action="item_delete.php";
	document.actionItem.submit();
	}
}

function setUpdateActionItem() {
	document.actionItem.action="item_update.php";
	document.actionItem.submit();
}


function setDeleteActionEmployee(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionEmployee.action="employee_delete.php";
	document.actionEmployee.submit();
	}
}

function setUpdateActionEmployee() {
	document.actionEmployee.action="employee_update.php";
	document.actionEmployee.submit();
}



function setDeleteActionStatus(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionStatus.action="status_delete.php";
	document.actionStatus.submit();
	}
}

function setUpdateActionStatus() {
	document.actionStatus.action="status_update.php";
	document.actionStatus.submit();
}


function setDeleteActionAvail(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionAvail.action="avail_delete.php";
	document.actionAvail.submit();
	}
}

function setUpdateActionAvail() {
	document.actionAvail.action="avail_update.php";
	document.actionAvail.submit();
}


function setUpdateActionCategory() {
	document.actionCategory.action="category_update.php";
	document.actionCategory.submit();
}

function setDeleteActionCategory(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionCategory.action="category_delete.php";
	document.actionCategory.submit();
	}

}


function setUpdateActionCategory2() {
	document.actionCategory2.action="category2_update.php";
	document.actionCategory2.submit();
}

function setDeleteActionCategory2(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionCategory2.action="category2_delete.php";
	document.actionCategory2.submit();
	}
}


function setUpdateActionIndi() {
	document.actionIndi.action="indi_update.php";
	document.actionIndi.submit();
}

function setDeleteActionIndi(){
	if(confirm("Are you sure you want to delete this record?")){
	document.actionIndi.action="indi_delete.php";
	document.actionIndi.submit();
	}
}
