<?php

/**
 * Url Make
 */
Class Link
{
	public static function createUrl($url)
	{
		return 'http://'.$_SERVER['HTTP_HOST'].'/'.$url;
	}
}