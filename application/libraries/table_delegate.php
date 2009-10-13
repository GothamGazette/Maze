<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Libraries
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


class Table_delegate
{
    /**
     * Name of table
     *
     * @var string
     * @access private
     */
    var $_table_name;

    /**
     * Name of primary key column
     *
     * @var string
     * @access private
     */
    var $_table_primary_key_column;

    /**
     * Last error message returned by the database
     *
     * @var string
     * @access private
     */
    var $_error_message;

    /**
     * Implements __construct functionality for PHP4
     *
     * @return Table_delegate
     */
    function Table_delegate()
    {
        $args = func_get_args();
        call_user_func_array(array($this, '__construct' ), $args);
    }

    /**
     * Constructor
     *
     * @param string $table			Name of table
     * @param string $key_column	Name of primary key column, defaults to 'id'
     * @param string $key_value		Value of primary key, defaults to null
     * @return Table_delegate
     */
    function __construct($table = null, $key_column = 'id', $key_value = null)
    {
        $CI =& get_instance();

        $this->_parent_name = ucfirst(get_class($this));

        $this->_table_name = $table;
        $this->_table_primary_key_column = $key_column;
        $this->$key_column = $key_value;

        $CI->load->helper('array_helper');
        $CI->load->helper('object_helper');
    }

    /**
     * Get the name of the table
     *
     * @access public
     * @return string	The name of the table
     */
    function getTableName()
    {
        return $this->_table_name;
    }

    /**
     * Get the name of the primary key column
     *
     * @access public
     * @return string	The name of the primary key column
     */
    function getPrimaryKeyName()
    {
        return $this->_table_primary_key_column;
    }

    /**
     * Resets the table delegate to the initial state
     *
     * @access public
     */
    function reset()
    {
        $k = $this->getTableName();
        foreach (ObjectHelper::getPublicProperties($this) as $property)
        {
            if ($property != $this->getPrimaryKeyName())
            {
                $this->$property = null;
            }
        }
    }

    /**
     * Binds the table delegate to an associative array or object with keys or public attributes
     * that match the table delegates public attributes
     *
     * @access public
     * @param mixed $source		The source of the binding
     */
    function bind($source)
    {
        if (true === is_array($source))
        {
            ArrayHelper::bindArrayToObject($source, $this, true);
        }
        else if (true === is_object($source))
        {
            ObjectHelper::shallowCopy($source, $this, true, true);
        }
    }

    /**
     * Load a record from the database using either the supplied id
     * or the value of the id attribute for the delegate
     *
     * @access public
     * @param mixed $id				Id to load, if not provided attempts to use
     * 								the value of the key column attribute for the delegate
     * @param string $key_column	The column to locate the record by.  If not provided uses the
     * 								primary key column for the delegate
     * @return boolean	Whether the load was successful
     */
    function load($id = null, $key_column = null)
    {
        $db = &$this->getDb();

        if (null === $key_column)
        {
            $key_column = $this->getPrimaryKeyName();
        }

        if (null !== $id) {
            $this->$key_column = $id;
        }

        $id = $this->$key_column;

        if (null === $key_column)
        {
            return false;
        }

        $columns = $this->_protectColumns($this->_getColumns());

        $query = 'SELECT ' . implode(',', $columns)
        . ' FROM ' . $db->protect_identifiers($this->getTableName())
        . ' WHERE ' . $db->protect_identifiers($key_column) . ' = ?';
         
        $result = $db->query($query, $id);

        if (false !== $result)
        {
            return $this->bind($result->row_array());
        }
        else
        {
            $this->_error_message = $db->_error_message();
            return false;
        }
    }

    /**
     * Inserts a record into the database table for the current delegate
     *
     * @access public
     * @return mixed	False if the query failed, otherwise the database result
     */
    function insert()
    {
        $db = &$this->getDb();

        $key_column = $this->getPrimaryKeyName();

        $columns = $this->_getColumns();
        unset($columns[$key_column]);

        $values = array();
        
        foreach ($columns as $column)
        {
            if (null !== $this->$column)
            {
                $values[] = $db->escape($this->$column);
            }
            else
            {
                unset($columns[$column]);
            }
        }

        $insert_columns = $this->_protectColumns($columns);

        $query = 'INSERT INTO ' . $db->protect_identifiers($this->getTableName())
        . ' (' . implode(',', $insert_columns) . ') VALUES (';


        $query .= implode(',', $values) . ')';

        $successful = $db->query($query);

        if (false !== $successful)
        {
            $this->$key_column = $db->insert_id();
        }

        return $successful;
    }

    /**
     * Updates the current row mapped to the delegate
     *
     * @access public
     * @param boolean $update_null_values	Whether to update attributes of the delegate that are null
     * @return mixed						False if the query failed, otherwise the database result
     */
    function update($update_null_values = false)
    {
        $db = &$this->getDb();

        $key_column = $this->getPrimaryKeyName();
        $id = $this->$key_column;

        if (null === $id)
        {
            return false;
        }

        $columns = $this->_getColumns();
        unset($columns[$key_column]);

        $updates = array();
        $values = array();

        foreach ($columns as $column)
        {
            if (true === $update_null_values || (null !== $this->$column && '' !== $this->$column))
            {
                $updates[] = $db->protect_identifiers($column) . '= ' . $db->escape($this->$column);
            }
        }

        $query = 'UPDATE ' . $db->protect_identifiers($this->getTableName()) . ' SET '
        . implode(', ', $updates)
        . ' WHERE ' . $db->protect_identifiers($key_column) . ' = ' . $id . ' LIMIT 1';

        $values[] = $id;

        return $db->query($query);
    }

    /**
     * Inserts the record if there is not a primary key value supplied, otherwise
     * updates the record
     *
     * @access public
     * @param boolean $update_null_values	Whether to update attributes of the delegate that are null
     * @return mixed						False if the query failed, otherwise the database result
     */
    function store($update_null_values = false)
    {
        $key_column = $this->getPrimaryKeyName();
        $id = $this->$key_column;

        if (null !== $id && 0 < $id)
        {
            return $this->update($update_null_values);
        }
        else
        {
            return $this->insert();
        }
    }

    /**
     * Deletes a record from the database using either the supplied id
     * or the value of the id attribute for the delegate
     *
     * @access public
     * @param int $id		Id to delete, if not provided attempts to use
     * 						the value of the primary key attribute for the delegate
     * @return mixed		False if the query failed, otherwise the database result
     */
    function delete($id = null)
    {
        $db = &$this->getDb();

        $key_column = $this->getPrimaryKeyName();

        if (null !== $id) {
            $this->$key_column = $id;
        }

        $id = $this->$key_column;

        if (null === $key_column)
        {
            return false;
        }

        $query = 'DELETE FROM ' . $db->protect_identifiers($this->getTableName())
        . ' WHERE ' . $db->protect_identifiers($key_column) . ' = ? LIMIT 1';
         
        return $db->query($query, $id);
    }

    /**
     * Protects array of identifiers, e.g. places backticks around identifier for MySQL
     *
     * @access protected
     * @param array $columns		Array of identifiers
     * @return array				Array of identifiers
     */
    function _protectColumns($columns)
    {
        $db = &$this->getDb();

        foreach($columns as $key => $value)
        {
            $columns[$key] = $db->protect_identifiers($value);
        }

        return $columns;
    }

    /**
     * Returns a list of columns, one for each public attribute of the delegate
     *
     * @access protected
     * @return array	List of columns
     */
    function _getColumns()
    {
        return ObjectHelper::getPublicProperties($this);
    }

    /**
     * Database reference
     *
     * @access public
     * @return CI_DB_driver
     */
    function &getDb()
    {
        $CI = &get_instance();
        return $CI->db;
    }

    /**
     * Returns the last error message
     *
     * @access public
     * @return string
     */
    function getErrorMessage()
    {
        return $this->_error_message;
    }

    /**
     * Sets error message
     *
     * @access protected
     * @param string $msg	New error message
     */
    function setErrorMessage($msg)
    {
        $this->_error_message = $msg;
    }

    /**
     * Assign Libraries
     *
     * Creates local references to all currently instantiated objects
     * so that any syntax that can be legally used in a controller
     * can be used within models.
     *
     * @access private
     */
    function _assign_libraries($use_reference = TRUE)
    {
        $CI =& get_instance();
        foreach (array_keys(get_object_vars($CI)) as $key)
        {
            if ( ! isset($this->$key) AND $key != $this->_parent_name)
            {
                // In some cases using references can cause
                // problems so we'll conditionally use them
                if ($use_reference == TRUE)
                {
                    // Needed to prevent reference errors with some configurations
                    $this->$key = '';
                    $this->$key =& $CI->$key;
                }
                else
                {
                    $this->$key = $CI->$key;
                }
            }
        }
    }
}
?>
