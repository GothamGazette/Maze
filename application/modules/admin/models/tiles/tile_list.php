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

class Tile_list extends Model
{
	private $_tiles;
	private $_tilecount;
	
	public function Tile_list()
	{
		parent::Model();
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
		$limit_start = (int)$this->uri->segment(4);
		$limit_start = (false === empty($limit_start)) ? $limit_start : 0;
		
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('tiles')
		. ' ORDER BY category'
		. ' LIMIT ?,?';
		
		$rs = $this->db->query($query, array($limit_start, 20));
		$this->_tiles = $rs->result();
	}
	
	public function getTileCount()
	{
		if (null === $this->_tilecount)
		{
			$this->_loadTileCount();
		}
		
		return $this->_tilecount;
	}
	
	private function _loadTileCount()
	{
		$query = 'SELECT COUNT(*) AS tilecount FROM ' . $this->db->protect_identifiers('tiles');
		
		$rs = $this->db->query($query);
		$result = $rs->row();
		$this->_tilecount = $result->tilecount;
	}
}
?>