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

class User_list extends Model
{
	private $_users;
	private $_usercount;
	
	public function User_list()
	{
		parent::Model();
	}
	
	public function &getUsers()
	{
		if (null === $this->_users)
		{
			$this->_loadUsers();
		}
		
		return $this->_users;
	}
	
	private function _loadUsers()
	{
		$limit_start = (int)$this->uri->segment(4);
		$limit_start = (false === empty($limit_start)) ? $limit_start : 0;
		
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('users')
		. ' LIMIT ?,?';
		
		$rs = $this->db->query($query, array($limit_start, 20));
		$this->_users = $rs->result();
	}
	
	public function getUserCount()
	{
		if (null === $this->_usercount)
		{
			$this->_loadUserCount();
		}
		
		return $this->_usercount;
	}
	
	private function _loadUserCount()
	{
		$query = 'SELECT COUNT(*) AS usercount FROM ' . $this->db->protect_identifiers('users');
		
		$rs = $this->db->query($query);
		$result = $rs->row();
		$this->_usercount = $result->usercount;
	}
}
?>