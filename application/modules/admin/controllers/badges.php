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

class Badges extends Controller
{
    public function Badges()
    {
        parent::Controller();
        
        if (false == $this->usersession->isAuthorized('Badges', 'Edit'))
        {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $task = $this->input->post('task');
        $task = (false === empty($task)) ? $task : 'badgelist';
        $this->$task();
    }

    public function badgelist()
    {
        $this->load->model('badges/badge_list');
        $this->load->library('pagination');

        $header_data = array();
        $header_data['actions'] = array('Create', 'Edit', 'Delete');
        $header_data['title'] = 'Badges';

        $config['base_url'] = site_url('admin/badges/badgelist');
        $config['total_rows'] = $this->badge_list->getBadgeCount();
        $config['per_page'] = '20';
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);

        $data = array();
        $data['badges'] = &$this->badge_list->getBadges();

        $this->load->view('header', $header_data);
        $this->load->view('badges/list', $data);
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
        $this->load->table('badge');
		$this->load->model('badges/badge_edit');
		
		$badge = new Badge_delegate($id);
		$badge->load();
		
        $header_data = array();
        $header_data['actions'] = array('Save', 'Cancel');
        $header_data['title'] = ((0 < $id) ? 'Edit' : 'New') . ' Badge';

        $data = array();
        $data['badge'] = $badge;

		$levels = &$this->badge_edit->getLevels();
		
		$level_list = array('' => 'Select One');
		foreach ($levels as $level)
		{
			$level_list[$level->id] = $level->title;
		}
		
		$data['levels'] = form_dropdown('level_id', $level_list, $badge->level_id);
		
        $this->load->view('header', $header_data);
        $this->load->view('badges/edit', $data);
        $this->load->view('footer');
    }

    public function cancel()
    {
        redirect('admin/badges');
    }

    public function save()
    {
        $this->load->table('badge');
        $badge = new Badge_delegate();
        $badge->bind($_POST);
        $badge->store();

        redirect('admin/badges');
    }

    public function delete()
    {
        $cid = $this->input->post('cid');
        $cid = (true === is_array($cid)) ? $cid : array();

        if (0 < sizeof($cid))
        {
            $query = 'DELETE FROM ' . $this->db->protect_identifiers('badges')
            . ' WHERE id IN (' . implode(',', $cid) . ')';
            	
            $this->db->query($query);
        }

        redirect('admin/badges');
    }
}
?>