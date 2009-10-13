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

class Room_list extends Model
{
	private $_rooms;
	private $_roomcount;
	private $_tiles;
	private $_levels;
	
	public function Room_list()
	{
		parent::Model();
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
		$limit_start = (int)$this->uri->segment(4);
		$limit_start = (false === empty($limit_start)) ? $limit_start : 0;
		
		$query = 'SELECT r.*, l.title AS level_title, q.title AS question_title, t.name AS tile_name FROM ' . $this->db->protect_identifiers('rooms') . ' AS r'
		. ' LEFT OUTER JOIN ' . $this->db->protect_identifiers('levels') . ' AS l ON l.id = r.level_id'
		. ' LEFT OUTER JOIN ' . $this->db->protect_identifiers('questions') . ' AS q ON q.id = r.question_id'
		. ' LEFT OUTER JOIN ' . $this->db->protect_identifiers('tiles') . ' AS t ON t.id = r.tile_id'
		. ' ' . $this->_getWhere()
		. ' ORDER BY r.level_id, r.row, r.column'
		. ' LIMIT ?,?';
		
		$rs = $this->db->query($query, array($limit_start, 20));
		$this->_rooms = $rs->result();
	}
	
	private function _getWhere()
	{
		$level_id = getRequestState('rooms.level', 'level_id');
		$tile_id = getRequestState('rooms.tile', 'tile_id');
		$row = getRequestState('rooms.row', 'row');
		$column = getRequestState('rooms.column', 'column');

		$where = array();
		
		if (false === empty($level_id))
		{
			$where[] = 'r.level_id = ' . $level_id;
		}
		
		if (false === empty($tile_id))
		{
			$where[] = 'r.tile_id = ' . $tile_id;
		}
		
		if (false === empty($row))
		{
			$where[] = 'r.row = ' . $row;
		}
		
		if (false === empty($column))
		{
			$where[] = 'r.column = ' . $column;
		}
		
		return (0 < sizeof($where)) ? 'WHERE ' . implode(' AND ', $where) : '';
	}
	
	public function getRoomCount()
	{
		if (null === $this->_roomcount)
		{
			$this->_loadRoomCount();
		}
		
		return $this->_roomcount;
	}
	
	private function _loadRoomCount()
	{
		$query = 'SELECT COUNT(*) AS roomcount FROM ' . $this->db->protect_identifiers('rooms') . ' AS r'
		. ' ' . $this->_getWhere();
		
		$rs = $this->db->query($query);
		$result = $rs->row();
		$this->_roomcount = $result->roomcount;
	}
	
	public function &getTiles()
	{
		if (null === $this->_tiles)
		{
			$this->_loadTiles();
		}
		
		return $this->_tiles;
	}
	
	private function _loadTiles()
	{
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('tiles')
		. ' ORDER BY id';
		
		$rs = $this->db->query($query);
		$this->_tiles = $rs->result();
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
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('levels')
		. ' ORDER BY id';
		
		$rs = $this->db->query($query);
		$this->_levels = $rs->result();
	}
}
?>