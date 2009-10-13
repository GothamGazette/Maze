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

class Badge_list extends Model
{
	private $_badges;
	private $_badgecount;
	
	public function Badge_list()
	{
		parent::Model();
	}
	
	public function &getBadges()
	{
		if (null === $this->_badges)
		{
			$this->_loadBadges();
		}
		
		return $this->_badges;
	}
	
	private function _loadBadges()
	{
		$limit_start = (int)$this->uri->segment(4);
		$limit_start = (false === empty($limit_start)) ? $limit_start : 0;
		
		$query = 'SELECT b.*, l.title AS level_title'
		. ' FROM ' . $this->db->protect_identifiers('badges') . ' AS b'
		. ' LEFT OUTER JOIN ' . $this->db->protect_identifiers('levels') . ' AS l ON l.id = b.level_id'
		. ' ORDER BY l.id, b.minimum_points'
		. ' LIMIT ?,?';
		
		$rs = $this->db->query($query, array($limit_start, 20));
		$this->_badges = $rs->result();
	}
	
	public function getBadgeCount()
	{
		if (null === $this->_badgecount)
		{
			$this->_loadBadgeCount();
		}
		
		return $this->_badgecount;
	}
	
	private function _loadBadgeCount()
	{
		$query = 'SELECT COUNT(*) AS badgecount FROM ' . $this->db->protect_identifiers('badges');
		
		$rs = $this->db->query($query);
		$result = $rs->row();
		$this->_badgecount = $result->badgecount;
	}
}
?>