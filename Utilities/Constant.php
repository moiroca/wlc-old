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
		REQUISITION_FINISHED = 'Finished',
		REQUISITION_ONGOING = 'On Going',
		REQUISITION_DECLINED = 'Declined',
		APPROVED_BY_GSD_OFFICER = 'Approved By GSD Officer', 
		APPROVED_BY_PRESIDENT = 'Approved By President',
		DECLINED_BY_GSD_OFFICER = 'Declined By GSD Officer', 
		DECLINED_BY_PRESIDENT = 'Declined By President',

		// Notifications Status
		NOTIFICATION_VIEWED = 'True',
		NOTIFICATION_NOT_VIEWED = 'False',

		// Notifications Messages
		NOTIFICATION_APPROVED_BY_PRESIDENT = "Your requesition has been approved by the President.",
		NOTIFICATION_APPROVED_BY_GSD_OFFICER   = "Your requesition has been approved by the GSD Officer.",
		NOTIFICATION_NEW_ITEM_REQUISITION 	   = "New Item Requisition",
		NOTIFICATION_NEW_JOB_REQUISITION 	   = "New Job Requisition",
		NOTIFICATION_FOR_APPROVAL_BY_PRESIDENT = "New Requistion For Approval",
		NOTIFICATION_REQUISTION_DECLINED_BY_GSD_OFFICER	   = "You requisition has been declined by GSD Officer",
		NOTIFICATION_REQUISTION_DECLINED_BY_President	   = "You requisition has been declined by President";
}