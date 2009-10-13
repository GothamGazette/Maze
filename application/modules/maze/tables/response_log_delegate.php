<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Maze
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

class Response_log_delegate extends Table_delegate
{
    public $id;
    public $response_id;
    public $gamesession_id;
    public $time_recorded;
    
    public function __construct($id = null)
    {
        parent::__construct('response_log', 'id', $id);
    }
    
    public function insert()
    {
        if (null === $this->time_recorded)
        {
            $this->time_recorded = standard_date('DATE_ISO8601', time());
        }
        
        parent::insert();
    }
}
?>