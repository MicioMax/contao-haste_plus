<?php

/**
 * Haste utilities for Contao Open Source CMS
 *
 * Copyright (C) 2012-2013 Codefog & terminal42 gmbh
 *
 * @package    Haste
 * @link       http://github.com/codefog/contao-haste/
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Haste\Test\Util;

include_once __DIR__ . '/../../../../../library/Haste/Util/Arrays.php';

use HeimrichHannot\Haste\Util\Arrays;


class ArraysTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getListPositonCssClassProvider
	 * @test
	 */
	public function testGetListPositonCssClass($key, $arrList, $blnReturnAsArray, $expectedResult)
	{
		$this->assertSame($expectedResult, Arrays::getListPositonCssClass($key, $arrList, $blnReturnAsArray));
	}

	/**
	 * @dataProvider filterByPrefixesProvider
	 * @test
	 */
	public function testFilterByPrefixes($arrData, $arrPrefixes, $expectedResult)
	{
		$this->assertSame($expectedResult, Arrays::filterByPrefixes($arrData, $arrPrefixes));
	}

	public function getListPositonCssClassProvider()
	{
		$arrList = [
			0   => 'foo',
			'a' => 'bar',
			'b' => 'fu',
			1   => 'ba',];

		return [
            [
				0,
				$arrList,
				false,
				'first odd'
            ],
            [
				'a',
				$arrList,
				false,
				'even'
            ],
            [
				'b',
				$arrList,
				false,
				'odd'
            ],
            [
				1,
				$arrList,
				false,
				'even last'
            ],
            [
                1,
                $arrList,
                true,
                ['even', 'last']
            ],
        ];
	}


	public function filterByPrefixesProvider()
	{
		$arrData = [
			'id'                     => 1,
			'youtube_template'       => 'youtube_default',
			'youtubePrivacy'         => true,
			'youtubePrivacyTemplate' => 'youtubeprivacy_default',
			'youTube'                => 'Fu',
			''                       => 'Bar',];

		return [
            [
                $arrData,
                ['youtube'],
                [
					'youtube_template'       => 'youtube_default',
					'youtubePrivacy'         => true,
					'youtubePrivacyTemplate' => 'youtubeprivacy_default',
                ],
            ],
            [
                $arrData,
                ['youTube'],
                [
					'youTube' => 'Fu',
                ],
            ],
        ];
	}
}
