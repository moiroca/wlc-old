<?php

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';

/**
 * Departments Class
 */
Class Area extends Base
{
	public $table = 'areas';

	public function __construct()
	{
		parent::__construct();
	}
}