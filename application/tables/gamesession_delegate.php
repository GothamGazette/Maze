<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Tables
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

class Gamesession_delegate extends Table_delegate
{
    public $id;
    public $hash;
    public $level_id;
    public $points;
    public $time_remaining;
    public $created;
    public $last_modified;
    public $completed;
    
    public function __construct($id = null)
    {
        parent::__construct('gamesessions', 'id', $id);
    }
    
    public function insert()
    {
        /**
         * If the hash doesn't exist create it
         */
        if (true === empty($this->hash))
        {
            $this->hash = md5(uniqid(rand(), true));
        }
        
        $this->created = standard_date('DATE_ISO8601', time());
        
        parent::insert();
    }
    
    public function update($update_null_values = false)
    {
        $this->last_modified = standard_date('DATE_ISO8601', time());
        
        parent::update($update_null_values);
    }
}
?>