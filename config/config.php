<?php

/**
 * Assets
 */
if(TL_MODE == 'FE')
{
	array_insert($GLOBALS['TL_JAVASCRIPT'], 0, array(
		'haste_plus' => '/system/modules/haste_plus/assets/js/haste_plus.js|static',
		'haste_plus_environment' => '/system/modules/haste_plus/assets/js/environment.js|static',
		'haste_plus_files' => '/system/modules/haste_plus/assets/js/files.js|static',
		'haste_plus_arrays' => '/system/modules/haste_plus/assets/js/arrays.js|static'
	));
}
