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
 * Provides general purpose object manipulation functions
 */

class ObjectHelper
{
    /**
     * Returns an associative array containing values from the object's
     * public properties. By default objects, arrays, and null values
     * are not in the array.
     *
     * @param object $object				The object
     * @param boolean $ignoreObjectsArrays	If True objects and arrays are not copied
     * @param boolean $ignoreNulls			If True null values are not copied
     * @param array $ignoreFields			Array of attributes to ignore
     * @return array						The associative array
     */
    function toArray(&$object, $ignoreObjectsArrays = true, $ignoreNulls = true, $ignoreFields = array())
    {
        $array						= array();

        foreach (ObjectHelper::getPublicProperties($object) as $key)
        {
            if (false === array_search($key, $ignoreFields))
            {
                $value			= $object->$key;

                if (true === is_object($value) || true === is_array($value))
                {
                    if ($ignoreObjectsArrays)
                    {
                        continue;
                    }
                    else
                    {
                        $array[$key]	= $value;
                    }
                }
                else if (null === $value && true === $ignoreNulls )
                {
                    continue;
                }
                else
                {
                    $array[$key]		= $value;
                }
            }
        }

        return $array;
    }

    /**
     * Sets public attributes on an object to those held in another object
     * By default does not copy entries in the array that do not correspond
     * to an attribute in the object.  Also takes an optional array
     * of fields to ignore.
     *
     * @param object $src						Object to copy from
     * @param object $dest						Object to copy to
     * @param boolean $ignoreObjectsArrays		If True objects and arrays are not copied
     * @param boolean $ignoreMissingAttributes	If True does not copy attributes not found
     * 											in the object
     * @param array $ignoreFields				Array of fields to ignore
     */
    function shallowCopy(&$src, &$dest, $ignoreObjectsArrays = true, $ignoreMissingAttributes = true, $ignoreFields = array())
    {
        $allowedKeys			= ObjectHelper::getPublicProperties($src, $ignoreFields);

        if (true === $ignoreMissingAttributes)
        {
            $allowedKeys		= array_intersect($allowedKeys, ObjectHelper::getPublicProperties($dest, $ignoreFields));
		}

        if (true === is_array($allowedKeys) && true === is_object($dest))
        {
            foreach ($allowedKeys as $key)
            {
                $value			= $src->$key;

                if (true === is_object($value) || true === is_array($value))
                {
                    if ($ignoreObjectsArrays)
                    {
                        continue;
                    }
                    else
                    {
                        $dest->$key	= &$value;
                    }
                }
                else
                {
                    $dest->$key	= $value;
                }
            }
        }

        return true;
    }

    /**
     * Returns an array of public properties in an object.
     * Public properties are those that do not begin with
     * an underscore
     *
     * @param object $object	Object
     * @param array	 $ignoreFields	Array of fields to ignore
     * @return array			Array of public properties
     */
    function getPublicProperties( &$object, $ignoreFields = array() )
    {
        $variables				= array();
        foreach (get_object_vars($object) as $key => $value)
        {
            if ('_' != substr($key, 0, 1) && false === in_array($key, $ignoreFields))
            {
                $variables[$key]	= $key;
            }
        }

        return $variables;
    }

    /**
     * Returns a value from an object or, if not found, the default value provided
     *
     * @param object $object		The object
     * @param string $attribute		Attribute name
     * @param mixed $default		Default value
     * @return mixed				The value
     */
    function getValue( &$object, $attribute, $default = null )
    {
        foreach (get_object_vars($object) as $key => $value)
        {
            if ($key == $attribute)
            {
                return $value;
            }
        }

        return $default;
    }
	
	function dumpPublicProperties(&$object, $ignoreFields = array())
	{
		$ci = &get_instance();
		$ci->load->library('table');
		$ci->table->clear();
		
		$data = array();
		$data[] = array('', '');
		
		foreach (self::getPublicProperties(&$object, $ignoreFields) as $key)
		{
			$data[] = array($key, $object->$key);
		}
		
		return $ci->table->generate($data);
	}
}
?>