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

class Level_list extends Model
{
	private $_levels;
	private $_levelcount;
	
	public function Level_list()
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
		$limit_start = (int)$this->uri->segment(4);
		$limit_start = (false === empty($limit_start)) ? $limit_start : 0;
		
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('levels')
		. ' LIMIT ?,?';
		
		$rs = $this->db->query($query, array($limit_start, 20));
		$this->_levels = $rs->result();
	}
	
	public function getLevelCount()
	{
		if (null === $this->_levelcount)
		{
			$this->_loadLevelCount();
		}
		
		return $this->_levelcount;
	}
	
	private function _loadLevelCount()
	{
		$query = 'SELECT COUNT(*) AS levelcount FROM ' . $this->db->protect_identifiers('levels');
		
		$rs = $this->db->query($query);
		$result = $rs->row();
		$this->_levelcount = $result->levelcount;
	}
}
?>