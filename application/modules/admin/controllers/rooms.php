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

class Rooms extends Controller
{
	public function Rooms()
	{
		parent::Controller();
		
	    if (false == $this->usersession->isAuthorized('Rooms', 'Edit'))
        {
            redirect('admin/login');
        }
	}
	
	public function index()
	{
		$task = $this->input->post('task');
		$task = (false === empty($task)) ? $task : 'roomlist';
		$this->$task();
	}
	
	public function roomlist()
	{
		$this->load->model('rooms/room_list');
		$this->load->library('pagination');
		
		$header_data = array();
		$header_data['actions'] = array('Create', 'Edit', 'Delete');
		$header_data['title'] = 'Rooms';
		
		$config['base_url'] = site_url('admin/rooms/roomlist');
		$config['total_rows'] = $this->room_list->getRoomCount();
		$config['per_page'] = '20'; 
	 	$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config); 
		
		$data = array();
		$data['rooms'] = &$this->room_list->getRooms();
		
		$levels = &$this->room_list->getLevels();
		
		$level_list = array('' => 'Filter Level');
		foreach ($levels as $level)
		{
			$level_list[$level->id] = $level->title;
		}
		
		$data['levels'] = form_dropdown('level_id', $level_list, getRequestState('rooms.level', 'level_id'));

		$tiles = &$this->room_list->getTiles();
		
		$tile_list = array('' => 'Filter Tile');
		foreach ($tiles as $tile)
		{
			$tile_list[$tile->id] = $tile->name;
		}
		
		$data['tiles'] = form_dropdown('tile_id', $tile_list, getRequestState('rooms.tile', 'tile_id'));
		
		$this->load->view('header', $header_data);
		$this->load->view('rooms/list', $data);
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
		$this->load->model('rooms/room_edit');
		
		$this->load->module_table('maze', 'room');
		$room = new Room_delegate($id);
		$room->load();
		
		if (0 == $id)
		{
			$room->start_point = 0;
			$room->end_point = 0;
		}
		
		$header_data = array();
		$header_data['actions'] = array('Save', 'Cancel');
		$header_data['title'] = ((0 < $id) ? 'Edit' : 'New') . ' Room';
		
		$data = array();
		$data['room'] = $room;
		
		$questions = &$this->room_edit->getQuestions();
		
		$question_list = array('' => 'None');
		foreach ($questions as $question)
		{
			$question_list[$question->id] = $question->title;
		}
		
		$data['questions'] = form_dropdown('question_id', $question_list, $room->question_id);
		
		$levels = &$this->room_edit->getLevels();
		
		$level_list = array('' => 'Select One');
		foreach ($levels as $level)
		{
			$level_list[$level->id] = $level->title;
		}
		
		$data['levels'] = form_dropdown('level_id', $level_list, $room->level_id);
		
		$orientations = array('' => 'None', 'north' => 'North', 'south' => 'South', 'east' => 'East', 'west' => 'West');
		
		$data['force_orientations'] = form_dropdown('force_orientation', $orientations, $room->force_orientation);
		
		$tiles = &$this->room_edit->getTiles();
		
		$tile_list = array('' => 'Select One');
		foreach ($tiles as $tile)
		{
			$tile_list[$tile->id] = $tile->name;
		}
		
		$data['tiles'] = form_dropdown('tile_id', $tile_list, $room->tile_id);
		
		$this->load->view('header', $header_data);
		$this->load->view('rooms/edit', $data);
        $this->load->view('footer');
	} 
	
	public function cancel()
	{
		redirect('admin/rooms');
	}
	
	public function save()
	{
		$this->load->module_table('maze', 'room');
		$room = new Room_delegate();
		$room->bind($_POST);
		$room->store(true);
		
		redirect('admin/rooms');
	}
	
	public function delete()
	{
		$cid = $this->input->post('cid');
		$cid = (true === is_array($cid)) ? $cid : array();
		
		if (0 < sizeof($cid))
		{
			$query = 'DELETE FROM ' . $this->db->protect_identifiers('rooms')
			. ' WHERE id IN (' . implode(',', $cid) . ')';
			
			$this->db->query($query);
		}
		
		redirect('admin/rooms');
	}
}
?>