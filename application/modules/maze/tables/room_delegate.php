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

class Room_delegate extends Table_delegate
{
    public $id;
    public $row;
    public $column;
    public $tile_id;
    public $level_id;
    public $image;
    public $description;
    public $question_id;
    public $start_point;
    public $end_point;
    public $force_orientation;
    public $override_exit_north;
    public $override_exit_south;
    public $override_exit_east;
    public $override_exit_west;
    
    public function __construct($id = null)
    {
        parent::__construct('rooms', 'id', $id);
    }
}
?>