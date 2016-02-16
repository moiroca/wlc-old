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
		USER_TREASURER			= 'Treasurer',
		USER_PROPERTY_CUSTODIAN = 'Property Custodian',
		USER_COMPTROLLER		= 'Comptroller',
		USER_EMPLOYEE			= 'Employee',
		USER_DEPARTMENT_HEAD	= 'Department Head',

		// User Status
		USER_ACTIVE	= 'Active',
		USER_DELETED = 'Deleted',

		// Stock Status
		STOCK_GOOD = 'Good Condition',
		STOCK_REPAIR = 'For Repair',
		STOCK_REPLACE = 'For Replace',
		

		STOCK_NEW_CONDITION  = 'New Condition',
		STOCK_FAIR_CONDITION = 'Fair Condition',
		STOCK_POOR_CONDITION = 'Poor Condition',
		STOCK_DELETED 		 = 'Deleted',
		STOCK_OBSOLETE		 = 'Obsolete',

		//Stock Requisition Statuses
		STOCK_APPROVED = 'Approved',
		STOCK_RECEIVED = 'Received',

		// Item Type
		ITEM_OFFICE_SUPPLY = 'Office Supply',
		ITEM_EQUIPMENT      = 'Equipment',
		ITEM_MATERIAL  = 'Material',
		ITEM_MATERIAL_EQUIPMENT = 'Material and Equipment',

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

		NOTED_BY_DEPARTMENT_HEAD = 'Noted By Department Head',
		DECLINED_BY_DEPARTMENT_HEAD = 'Declined By Department Head',

		VERIFIED_BY_PROPERTY_CUSTODIAN = 'Verified By Property Custodian', 
		DECLINED_BY_PROPERTY_CUSTODIAN = 'Declined By Property Custodian', 

		VERIFIED_BY_GSD_OFFICER = 'Verified By GSD Officer', 
		DECLINED_BY_GSD_OFFICER = 'Declined By GSD Officer', 

		APPROVED_BY_TREASURER = 'Approved By Treasurer',
		DECLINED_BY_TREASURER = 'Declined By Treasurer',

		APPROVED_BY_COMPTROLLER = 'Approved By Comptroller',
		DECLINED_BY_COMPTROLLER = 'Declined By Comptroller',

		APPROVED_BY_PRESIDENT = 'Approved By President',
		DECLINED_BY_PRESIDENT = 'Declined By President',

		RELEASED_BY_PROPERTY_CUSTODIAN = 'Released By Property Custodian',
		RELEASED_BY_GSD_OFFICER = 'Released By GSD Officer',
		RECEIVED_BY_REQUESTER = 'Received By Requester',

		ITEM_VERIFIED_BY_PRESIDENT = 'Item Verified By President',
		
		// Notifications Status
		NOTIFICATION_VIEWED = 'True',
		NOTIFICATION_NOT_VIEWED = 'False',

		// Notifications Messages
		NOTIFICATION_NOTED_BY_DEPARTMENT_HEAD = "Your requesition has been NOTED by the Department Head.",
		NOTIFICATION_DECLINED_BY_DEPARTMENT_HEAD = "Your requesition has been DECLINED by the Department Head.",

		NOTIFICATION_VERIFIED_BY_PROPERTY_CUSTODIAN = "Your requesition has been VERIFIED by the Property Custodian.",
		NOTIFICATION_DECLINED_BY_PROPERTY_CUSTODIAN = "Your requesition has been DECLINED by the Property Custodian.",

		NOTIFICATION_VERIFIED_BY_GSD_OFFICER   = "Your requesition has been VERIFIED by the GSD Officer.",
		NOTIFICATION_DECLINED_BY_GSD_OFFICER   = "Your requesition has been DECLINED by the GSD Officer.",

		NOTIFICATION_APPROVED_BY_COMPTROLLER	= "Your requesition has been APPROVED by the Comptroller.",
		NOTIFICATION_DECLINED_BY_COMPTROLLER    = "Your requesition has been DECLINED by the Comptroller.",

		NOTIFICATION_APPROVED_BY_TREASURER		= "Your requesition has been APPROVED by the Treasurer.",
		NOTIFICATION_DECLINED_BY_TREASURER    	= "Your requesition has been DECLINED by the Treasurer.",

		NOTIFICATION_APPROVED_BY_PRESIDENT 		= "Your requesition has been APPROVED by the President.",
		NOTIFICATION_DECLINED_BY_PRESIDENT 	   = "Your requesition has been DECLINED by the President.",
		
		NOTIFICATION_ITEM_VERIFIED_BY_PRESIDENT = "Your Requested Items has been approved",

		NOTIFICATION_RELEASED = "Your Item Requisition has been released.",

		NOTIFICATION_NEW_ITEM_REQUISITION 	   = "New Item Requisition",
		NOTIFICATION_NEW_JOB_REQUISITION 	   = "New Job Requisition",
		NOTIFICATION_FOR_APPROVAL_BY_PRESIDENT = "New Requistion For Approval";
}
