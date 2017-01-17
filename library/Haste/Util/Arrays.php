<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @package haste_plus
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Haste\Util;


class Arrays
{
	/**
	 * Create the class names for an item within a array list
	 *
	 * @param $key mixed The current index
	 * @param $arrList array The array list
	 * @param $blnReturnAsArray boolean Return as array, or String
	 *
	 * @return string | array String of class names, or an array if $blnReturnAsArray is true.
	 */
	public static function getListPositonCssClass($key, array $arrList, $blnReturnAsArray=false)
	{
		$arrClasses = [];

		$idx = array_search($key, array_keys($arrList), true);

		if($idx === false)
		{
			return $blnReturnAsArray ? $arrClasses : '';
		}

		if($idx == 0)
		{
			$arrClasses[] = 'first';
		}

		$arrClasses[] = ($idx%2 == 0) ? 'odd' : 'even';

		if($idx + 1 == count($arrList))
		{
			$arrClasses[] = 'last';
		}

		return $blnReturnAsArray ? $arrClasses : implode(' ', $arrClasses);
	}

	/**
	 * Filter an Array by given prefixes
	 *
	 * @param array  $arrData
	 * @param array  $arrPrefixes
	 *
	 * @return array the filtered array or $arrData if $strPrefix is empty
	 */
	public static function filterByPrefixes(array $arrData = [], $arrPrefixes = [])
	{
		$arrExtract = [];

		if(!is_array($arrPrefixes) || empty($arrPrefixes))
		{
			return $arrData;
		}

		foreach($arrData as $key => $value)
		{
			foreach($arrPrefixes as $strPrefix)
			{
				if(\HeimrichHannot\Haste\Util\StringUtil::startsWith($key, $strPrefix))
				{
					$arrExtract[$key] = $value;
				}
			}
		}
		
		return $arrExtract;
	}


	/**
	 * Filter out values from an Array by given prefixes
	 *
	 * @param array  $arrData
	 * @param array  $arrPrefixes
	 *
	 * @return array the filtered array or $arrData if $strPrefix is empty
	 */
	public static function filterOutByPrefixes(array $arrData = [], $arrPrefixes = [])
	{
		$arrExtract = [];

		if(!is_array($arrPrefixes) || empty($arrPrefixes))
		{
			return $arrData;
		}

		foreach($arrData as $key => $value)
		{
			foreach($arrPrefixes as $strPrefix)
			{
				if(\HeimrichHannot\Haste\Util\StringUtil::startsWith($key, $strPrefix))
				{
					continue;
				}

				$arrExtract[$key] = $value;
			}
		}

		return $arrExtract;
	}

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
		$tmp = [];
		foreach ($array as $key => $value) {
			$tmp[] = ['k' => $key, 'v' => $value];
		}
		shuffle($tmp);
		$array = [];
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
				$tmp = [];
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
		$sorter = [];
		$ret    = [];
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
		$arrResult = [];
		foreach ($objObject as $key => $value) {
			$arrResult[$key] = $value;
		}

		return $arrResult;
	}

	public static function arrayToObject($array)
	{
		$objResult = new \stdClass();
		foreach ($array as $varKey => $varValue)
		{
			$objResult->{$varKey} = $varValue;
		}
		return $objResult;
	}

	public static function insertInArrayByName(&$arrOld, $strKey, $arrNew, $intOffset = 0)
	{
		if (($intIndex = array_search($strKey, array_keys($arrOld))) !== false)
		{
			array_insert($arrOld, $intIndex + $intOffset, $arrNew);
		}
	}

	public static function isSerialized($varValue)
	{
		$data = @unserialize($varValue);
		return $varValue === 'b:0;' || $data !== false;
	}

	/**
	 * Uniques an array by key, not by value
	 */
	public static function array_unique_keys($array)
	{
		$arrResult = [];

		foreach (array_unique(array_keys($array)) as $varKey)
		{
			$arrResult[$varKey] = $array[$varKey];
		}

		return $arrResult;
	}

	/**
	 * Merges multiple arrays wrapped in another array by concating the values which must be concatable
	 *
	 * @param array $arrArray
	 *
	 * @return array|mixed
	 */
	public static function concatArrays($strDelimiter) {
		$arrArrays = func_get_args();
		array_shift($arrArrays);
		$arrResult = [];

		foreach ($arrArrays as $arrArray)
		{
			foreach ($arrArray as $varKey => $varValue)
			{
				if (isset($arrResult[$varKey]))
					$arrResult[$varKey] .= ($arrArray[$varKey] ? $strDelimiter : '') . $varValue;
				else
					$arrResult[$varKey] = $varValue;
			}
		}

		return $arrResult;
	}

	public static function getRowInMcwArray($strKey, $varValue, array $arrArray)
	{
		foreach ($arrArray as $arrRow)
		{
			if ($arrRow[$strKey] == $varValue)
				return $arrRow;
		}

		return false;
	}

	/**
	 * Removes a value in an array
	 * @param       $varValue
	 * @param array $arrArray
	 *
	 * @return bool Returns true if the value has been found and removed, false in other cases
	 */
	public static function removeValue($varValue, array &$arrArray)
	{
		if (($intPosition = array_search($varValue, $arrArray)) !== false)
		{
			unset($arrArray[$intPosition]);
			return true;
		}

		return false;
	}

	public static function flattenArray(array $array)
	{
		$return = [];
		array_walk_recursive(
			$array,
			function ($a) use (&$return) {
				$return[] = $a;
			}
		);

		return $return;
	}
}
