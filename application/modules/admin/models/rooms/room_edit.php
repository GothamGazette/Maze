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

class Room_edit extends Model
{
	private $_tiles;
	private $_questions;
	private $_levels;
	
	public function Room_edit()
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
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('tiles')
		. ' ORDER BY id';
		
		$rs = $this->db->query($query);
		$this->_tiles = $rs->result();
	}
	
	public function &getQuestions()
	{
		if (null === $this->_questions)
		{
			$this->_loadQuestions();
		}
		
		return $this->_questions;
	}
	
	private function _loadQuestions()
	{
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('questions')
		. ' ORDER BY id';
		
		$rs = $this->db->query($query);
		$this->_questions = $rs->result();
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