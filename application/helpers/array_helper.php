<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Helpers
 * @copyright	Copyright (C) 2008 Gotham Gazette. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Provides general purpose array manipulation functions
 */

class ArrayHelper
{
    /**
     * Sets public attributes on an object to those held in an associative array.
     * By default does not copy entries in the array that do not correspond
     * to an attribute in the object.  Also takes an optional array
     * of fields to ignore.
     *
     * @param array $array						Associative array of values
     * @param object $object					Object to copy to
     * @param boolean $ignoreMissingAttributes	If True does not copy attributes not found
     * 											in the object
     * @param array $ignoreFields				Array of fields to ignore
     */
    function bindArrayToObject($array, &$object, $ignoreMissingAttributes = true, $ignoreFields = array())
    {
        $allowedKeys            = array_keys($array);

        $allowedKeys            = array_diff($allowedKeys, $ignoreFields);

        if (true === $ignoreMissingAttributes)
        {
            $allowedKeys        = array_intersect($allowedKeys, ObjectHelper::getPublicProperties($object));
        }
        
        if (is_array($array) && is_object($object))
        {
            foreach ($allowedKeys as $key)
            {
                    $object->$key    = (true === isset($array[$key])) ? $array[$key] : null;
            }
        }

        return true;
    }

    /**
     * Implodes an associative array
     *
     * @param string $glue1			Glue between key and value of the associative array
     * @param string $glue2			Glue between elements in the array
     * @param array $array			Array
     * @return string				Imploded string
     */
    function implode_assoc($glue1, $glue2, &$array)
    {
        foreach ( $array as $key => $val )
        {
            $array2[] = $key . $glue1 . $val;
        }

        return implode($glue2, $array2);
    }
    
    function implode_keys($glue, &$array, $key)
    {
        $vals = array();

        foreach ($array as $item)
        {
            if (true === is_array($item) && true === isset($item[$key]))
            {
                $vals[] = $item[$key];
            }
            else if (true === is_object($item) && true === isset($item->$key))
            {
                $vals[] = $item->$key;
            }
        }
        
        return implode($glue, $vals);
    }
}
?>