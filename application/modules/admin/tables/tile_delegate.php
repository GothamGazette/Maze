<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Admin
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

class Tile_delegate extends Table_delegate
{
    public $id;
    public $category;
	public $map_image;
	public $default_image;
	public $exit_north;
	public $exit_east;
	public $exit_west;
	public $exit_south;
	public $name;
	public $allow_questions;
	
    public function __construct($id = null)
    {
        parent::__construct('tiles', 'id', $id);
    }
}
?>