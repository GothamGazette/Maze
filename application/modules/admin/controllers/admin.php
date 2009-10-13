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

class Admin extends Controller
{
	public function Admin()
	{
		parent::Controller();
	}
	
	public function index()
	{
		if (false == $this->usersession->isAuthorized('Admin Site', 'Login'))
		{
		    redirect('admin/login');
		}
		
		$this->load->view('header');
		$this->load->view('main');
        $this->load->view('footer');
	}
	
	public function login()
	{
		$this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
	}
	
	public function signin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if (true == $this->usersession->login($username, $password)
		&& $this->usersession->isAuthorized('Admin Site', 'Login'))
		{
			redirect('admin');
		}
		else
		{
			$this->login();
		}
	}
	
	public function logout()
	{
	    $this->usersession->logout();
	    redirect('');
	}
}
?>