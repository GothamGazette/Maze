<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Welcome
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

class Welcome extends Controller
{
    public function Welcome()
    {
        parent::Controller();
    }
    
    public function index()
    {
        $this->load->view('welcome');
        
        $this->khacl->aco->create('Public Site');
        $this->khacl->aco->create('Maze', 'Public Site');
        $this->khacl->aco->create('Admin Site');
        $this->khacl->aco->create('Users', 'Admin Site');
        $this->khacl->aco->create('Rooms', 'Admin Site');
        $this->khacl->aco->create('Questions', 'Admin Site');
        
        $this->khacl->aro->create('Public Site');
        $this->khacl->aro->create('Guest', 'Public Site', 1);
        $this->khacl->aro->create('User', 'Guest', 1);
        
        $this->khacl->aro->create('Admin Site');
        $this->khacl->aro->create('Administrator', 'Admin Site', 3);
        
        $this->khacl->axo->create('Login');
        $this->khacl->axo->create('Play');
        $this->khacl->axo->create('Edit');
        $this->khacl->axo->create('Delete');
        
        $this->khacl->allow('Guest', 'Maze', 'Play');
        $this->khacl->allow('Admin Site', 'Maze', 'Play');
        
        $this->khacl->allow('Admin Site', 'Admin Site', 'Login');
        $this->khacl->allow('Administrator', 'Users', 'Edit');
        $this->khacl->allow('Administrator', 'Users', 'Delete');
        $this->khacl->allow('Administrator', 'Rooms', 'Edit');
        $this->khacl->allow('Administrator', 'Rooms', 'Delete');
        $this->khacl->allow('Administrator', 'Questions', 'Edit');
        $this->khacl->allow('Administrator', 'Questions', 'Delete');
    }
}
?>