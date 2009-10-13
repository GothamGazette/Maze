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

class Tiles extends Controller
{
    public function Tiles()
    {
        parent::Controller();
        
        if (false == $this->usersession->isAuthorized('Tiles', 'Edit'))
        {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $task = $this->input->post('task');
        $task = (false === empty($task)) ? $task : 'tilelist';
        $this->$task();
    }

    public function tilelist()
    {
        $this->load->model('tiles/tile_list');
        $this->load->library('pagination');

        $header_data = array();
        $header_data['actions'] = array('Create', 'Edit', 'Delete');
        $header_data['title'] = 'Tiles';

        $config['base_url'] = site_url('admin/tiles/tilelist');
        $config['total_rows'] = $this->tile_list->getTileCount();
        $config['per_page'] = '20';
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);

        $data = array();
        $data['tiles'] = &$this->tile_list->getTiles();

        $this->load->view('header', $header_data);
        $this->load->view('tiles/list', $data);
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
        $this->load->table('tile');
		$tile = new Tile_delegate($id);
		$tile->load();
		
        $header_data = array();
        $header_data['actions'] = array('Save', 'Cancel');
        $header_data['title'] = ((0 < $id) ? 'Edit' : 'New') . ' Tile';

        $data = array();
        $data['tile'] = $tile;

        $this->load->view('header', $header_data);
        $this->load->view('tiles/edit', $data);
        $this->load->view('footer');
    }

    public function cancel()
    {
        redirect('admin/tiles');
    }

    public function save()
    {
        $this->load->table('tile');
        $tile = new Tile_delegate();
        $tile->bind($_POST);
        $tile->store();

        redirect('admin/tiles');
    }

    public function delete()
    {
        $cid = $this->input->post('cid');
        $cid = (true === is_array($cid)) ? $cid : array();

        if (0 < sizeof($cid))
        {
            $query = 'DELETE FROM ' . $this->db->protect_identifiers('tiles')
            . ' WHERE id IN (' . implode(',', $cid) . ')';
            	
            $this->db->query($query);
        }

        redirect('admin/tiles');
    }
}
?>