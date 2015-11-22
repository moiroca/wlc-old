<?php

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';

/**
 * Departments Class
 */
Class Department extends Base
{
	public $table = 'departments';

	public function __construct()
	{
		parent::__construct();
	}
}