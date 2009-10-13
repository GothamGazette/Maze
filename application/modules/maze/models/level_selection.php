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

class Level_Selection extends Model
{
    private $_levels;
    
    public function Maze_Selection()
    {
        parent::Model();
    }
    
    public function &getLevels()
    {
        if (null === $this->_levels)
        {
            $this->_loadLevels();
        }
        
        return $this->_levels;
    }
    
    private function _loadLevels()
    {
        $query = 'SELECT *'
        . ' FROM ' . $this->db->protect_identifiers('levels')
        . ' ORDER BY ' . $this->db->protect_identifiers('ordering');
        
        $rs = $this->db->query($query);
        $this->_levels = $rs->result();
    }
}
?>