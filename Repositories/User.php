<?php

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';

/**
 * Users Class
 */
Class User extends Base
{
	public $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}
}