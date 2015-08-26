<?php

namespace HeimrichHannot\HastePlus;

	/**
	 * Contao Open Source CMS
	 *
	 * Copyright (C) 2005-2013 Leo Feyer
	 *
	 * @package   haste_plus
	 * @author    d.patzer@heimrich-hannot.de
	 * @license   GNU/LGPL
	 * @copyright Heimrich & Hannot GmbH
	 */

/**
 * helper class for offering array functionality
 */

class Arrays
{

	/**
	 * shuffle an array (associative or non-associative) preserving keys
	 *
	 * @param string $array
	 *
	 * @return string Shuffled Array
	 */
	public static function kshuffle(&$array)
	{
		if (!is_array($array) || empty($array)) {
			return false;
		}
		$tmp = array();
		foreach ($array as $key => $value) {
			$tmp[] = array('k' => $key, 'v' => $value);
		}
		shuffle($tmp);
		$array = array();
		foreach ($tmp as $entry) {
			$array[$entry['k']] = $entry['v'];
		}

		return true;
	}

	public static function array_orderby()
	{
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
			}
		}
		$args[] = & $data;
		call_user_func_array('array_multisort', $args);

		return array_pop($args);
	}

	/**
	 * sort an array alphabetically by some key in the second layer (x => array(key1, key2, key3))
	 *
	 * @param string $array
	 *
	 * @return string Shuffled Array
	 */
	public static function aasort(&$array, $key)
	{
		$sorter = array();
		$ret    = array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii] = $va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii] = $array[$ii];
		}
		$array = $ret;
	}

	public static function objectToArray($objObject)
	{
		$arrResult = array();
		foreach ($objObject as $key => $value) {
			$arrResult[$key] = $value;
		}

		return $arrResult;
	}

}