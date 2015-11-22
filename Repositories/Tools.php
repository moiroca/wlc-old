<?php

include $_SERVER['DOCUMENT_ROOT'].'/Repositories/Base.php';

Class Tools extends Base
{
	public $table = 'stocks';

	public function __construct()
	{
		parent::__construct();
	}
}