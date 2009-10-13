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

class Users extends Controller
{
    public function Users()
    {
        parent::Controller();
        
        if (false == $this->usersession->isAuthorized('Users', 'Edit'))
        {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $task = $this->input->post('task');
        $task = (false === empty($task)) ? $task : 'userlist';
        $this->$task();
    }

    public function userlist()
    {
        $this->load->model('users/user_list');
        $this->load->library('pagination');

        $header_data = array();
        $header_data['actions'] = array('Create', 'Edit', 'Delete');
        $header_data['title'] = 'Users';

        $config['base_url'] = site_url('admin/users/userlist');
        $config['total_rows'] = $this->user_list->getUserCount();
        $config['per_page'] = '20';
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);

        $data = array();
        $data['users'] = &$this->user_list->getUsers();

        $this->load->view('header', $header_data);
        $this->load->view('users/list', $data);
        $this->load->view('footer');
    }

    public function create()
    {
        $this->editform();
    }

    public function edit()
    {
        $cid = $this->input->post('cid');
        $cid = (true === is_array($cid)) ? $cid : array();

        $id = (0 < sizeof($cid)) ? $cid[0] : 0;
        $this->editform($id);
    }

    public function editform($id = 0)
    {
        $this->load->table('user');
        $user = new User_delegate($id);
        $user->load();

        $header_data = array();
        $header_data['actions'] = array('Save', 'Cancel');
        $header_data['title'] = ((0 < $id) ? 'Edit' : 'New') . ' User';

        $data = array();
        $data['user'] = $user;

        $this->load->view('header', $header_data);
        $this->load->view('users/edit', $data);
        $this->load->view('footer');
    }

    public function cancel()
    {
        redirect('admin/users');
    }

    public function save()
    {
        $this->load->table('user');
        $user = new User_delegate();
        $user->bind($_POST);
        $user->store();

        $role = $this->input->post('roles');

        $query = 'DELETE FROM ' . $this->db->protect_identifiers('user_roles')
        . ' WHERE user_id = ?';
        	
        $this->db->query($query, array($user->id));
        
        if (false === empty($role))
        {
            $query = $this->db->insert_string('user_roles', array('user_id' => $user->id, 'role_id' => $role));
            $this->db->query($query);
        }
        	
        redirect('admin/users');
    }

    public function delete()
    {
        $cid = $this->input->post('cid');
        $cid = (true === is_array($cid)) ? $cid : array();

        if (0 < sizeof($cid))
        {
            $query = 'DELETE FROM ' . $this->db->protect_identifiers('users')
            . ' WHERE id IN (' . implode(',', $cid) . ')';
            	
            $this->db->query($query);
            	
            $query = 'DELETE FROM ' . $this->db->protect_identifiers('user_roles')
            . ' WHERE user_roles IN (' . implode(',', $cid) . ')';
            	
            $this->db->query($query);
        }

        redirect('admin/users');
    }
}
?>