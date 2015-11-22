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
		ITEM_MATERIAL  = 'Material';
}