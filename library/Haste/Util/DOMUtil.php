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


class DOMUtil
{
    /**
     * Create tag attributes from an array
     *
     * @param array $arrAttributes The tag attributes
     *
     * @return string The attributes as string key="value" key1="value1"
     */
    public static function createAttributes($attributes = [])
    {
        $list = [];

        foreach ($attributes as $key => $value)
        {
            $list[] = sprintf('%s="%s"', $key, is_array($value) ? implode(' ', $value) : $value);
        }

        return implode(' ', $list);
    }

    /**
     * @param       $strText
     * @param array $strCssText the css as text (no paths allowed atm)
     *
     * @throws \TijsVerkoyen\CssToInlineStyles\Exception
     */
    public static function convertToInlineCss($strText, $strCssText)
    {
        // prevent inlining inside conditional comments, see https://github.com/tijsverkoyen/CssToInlineStyles/issues/133
        $strCssText = preg_replace('/<!--(.*?)-->/Uis', '', $strCssText);

        // apply the css inliner
        $objCssInliner = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles($strText, $strCssText);

        return $objCssInliner->convert();
    }
}