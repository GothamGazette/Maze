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

class User_delegate extends Table_delegate
{
    public $id;
    public $username;
    public $email;
    public $hash;
    public $password;
    
    public function __construct($id = null)
    {
        parent::__construct('users', 'id', $id);
    }
	
	public function store($update_nulls = false)
	{
		if (false === empty($this->password))
		{
			$salt = $this->_generateSalt(8);
			$salted_password = md5($this->password . $salt);
			$this->password = $salted_password . ':' . $salt;
		}
		
		parent::store($update_nulls);
	}
	
	private function _generateSalt($length)
	{
		$string = md5(time());
		$highest_startpoint = 32-$length;
		return substr($string,rand(0,$highest_startpoint),$length);
	}
}
?>