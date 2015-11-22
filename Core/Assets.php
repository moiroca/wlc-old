<?php

/**
 * Handles Assets
 *
 * @since November 2015
 */
Class Assets 
{
	/**
	 * Render Css Link
	 *
	 * @param String $filename
	 */
	public static function renderCss($filenames)
	{
		foreach ($filenames as $filename) {
			$filename = 'http://'.$_SERVER['HTTP_HOST'].'/css/'.$filename;
			echo "<link rel='stylesheet' href=$filename />";
		}
	}

	/**
	 * Render JS
	 *
	 * @param String $filename
	 */
	public static function renderJs($filenames)
	{
		foreach ($filenames as $filename) {
			$filename = 'http://'.$_SERVER['HTTP_HOST'].'/js/'.$filename;
			echo "<script src=$filename type='text/javascript'></script>";
		}
	}
}
