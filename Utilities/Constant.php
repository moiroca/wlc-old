<?php

/**
 * @since November 2015
 */
Class Constant {
	
	CONST 

		// Database Credentials
		DB_NAME = 'wlcinventory',
		DB_HOST = 'localhost',
		DB_USER = 'moiroca',
		DB_PASS = '',

		// User Types
		USER_ADMIN 				= 'Admin',
		USER_GSD_OFFICER 		= 'GSD Officer',
		USER_INVENTORY_OFFICER 	= 'Inventory Officer',
		USER_PRESIDENT 			= 'President',
		USER_DEAN 				= 'Dean',

		// User Status
		USER_ACTIVE	= 'Active',
		USER_DELETED = 'Deleted',

		// Stock Status
		STOCK_GOOD = 'Good Condition',
		STOCK_REPAIR = 'For Repair',
		STOCK_REPLACE = 'For Replace',
		STOCK_DELETED = 'Deleted',

		// Item Type
		ITEM_EQUIPMENT = 'Equipment',
		ITEM_TOOL      = 'Tools',
		ITEM_MATERIAL  = 'Material',

		// Requisition Type
		REQUISITION_ITEM = 'Item',
		REQUISITION_JOB  = 'Job',

		// Requisition Status
		REQUISITION_APPROVED = 'Approved',
		REQUISITION_PENDING = 'Pending',
		REQUISITION_PARTIALLY_APPROVED = 'Partially Approved',
		REQUISITION_SENT = 'Sent',
		REQUISITION_FINISHED = 'Finished',
		REQUISITION_ONGOING = 'On Going',
		REQUISITION_DECLINED = 'Declined',

		// Notifications Status
		NOTIFICATION_VIEWED = 'True',
		NOTIFICATION_NOT_VIEWED = 'False',

		// Notifications Messages
		NOTIFICATION_APPROVED_BY_PRESIDENT_MSG = "Your request has been approved by the President.";
}