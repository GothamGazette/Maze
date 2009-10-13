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

class Level_detail extends Model
{
	private $_rooms;
	private $_id;
	private $_level;
	private $_responses;
	
	public function Level_detail()
	{
		parent::Model();
	}
	
	public function setId($id)
	{
		$this->_id = $id;
	}
	
	public function &getRooms()
	{
		if (null === $this->_rooms)
		{
			$this->_loadRooms();
		}
		
		return $this->_rooms;
	}
	
	private function _loadRooms()
	{
		$query = 'SELECT r.*, t.map_image, t.category'
		. ' FROM ' . $this->db->protect_identifiers('rooms') . ' AS r'
		. ' INNER JOIN ' .$this->db->protect_identifiers('tiles') . ' AS t ON t.id = r.tile_id'
		. ' WHERE r.level_id = ?';
		
		$rs = $this->db->query($query, array($this->_id));
		$this->_rooms = $rs->result();
	}
	
	public function &getLevel()
	{
		if (null === $this->_level)
		{
			$this->_level = new Level_delegate($this->_id);
			$this->_level->load();
		}
		
		return $this->_level;
	}
	
	public function &getResponses()
	{
	    if (null === $this->_responses)
	    {
	        $this->_loadResponses();
	    }
	    
	    return $this->_responses;
	}
	
	private function _loadResponses()
	{
	    $query = 'SELECT r.* FROM ' . $this->db->protect_identifiers('responses') . ' AS r'
	    . ' INNER JOIN ' . $this->db->protect_identifiers('questions') . ' AS q ON q.id = r.question_id'
	    . ' INNER JOIN ' . $this->db->protect_identifiers('rooms') . ' AS ro ON ro.question_id = q.id'
	    . ' WHERE ro.level_id = ?';
	    
	    $rs = $this->db->query($query, array($this->_id));
	    $this->_responses = $rs->result();
	}
}
?>
