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

class Questions extends Controller
{
	public function Questions()
	{
		parent::Controller();
		
	    if (false == $this->usersession->isAuthorized('Questions', 'Edit'))
        {
            redirect('admin/login');
        }
	}
	
	public function index()
	{
		$task = $this->input->post('task');
		$task = (false === empty($task)) ? $task : 'questionlist';
		$this->$task();
	}
	
	public function questionlist()
	{
		$this->load->model('questions/question_list');
		$this->load->library('pagination');
		
		$header_data = array();
		$header_data['actions'] = array('Create', 'Edit', 'Delete');
		$header_data['title'] = 'Questions';
		
		$config['base_url'] = site_url('admin/questions/questionslist');
		$config['total_rows'] = $this->question_list->getQuestionCount();
		$config['per_page'] = '20'; 
	 	$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config); 
		
		$data = array();
		$data['questions'] = &$this->question_list->getQuestions();

		$this->load->view('header', $header_data);
		$this->load->view('questions/list', $data);
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
		$this->load->model('questions/question_edit');
		
		$this->load->table('question');
		$question = new Question_delegate($id);
		$question->load();
		
		$this->question_edit->setId($id);
		
		if (0 == $id)
		{
			$question->start_point = 0;
			$question->end_point = 0;
		}
		
		$header_data = array();
		$header_data['actions'] = array('Save', 'Cancel');
		$header_data['title'] = ((0 < $id) ? 'Edit' : 'New') . ' Question';
		
		$data = array();
		$data['question'] = $question;
		
		$actions = array('' => 'Select One', 'click_response' => 'Click Response');
		
		$data['actions'] = form_dropdown('action_function', $actions, $question->action_function);
		$data['responses'] = &$this->question_edit->getResponses();
		
		$this->load->view('header', $header_data);
		$this->load->view('questions/edit', $data);
        $this->load->view('footer');
	} 
	
	public function cancel()
	{
		redirect('admin/questions');
	}
	
	public function save()
	{
		$this->load->table('question');
		$this->load->module_table('maze', 'response');
		
		$question = new Question_delegate();
		$question->bind($_POST);
		$question->store();
		
		$responses = $this->input->post('response');
		
		$response_ids = array();
		
		foreach ($responses as $response)
		{
		    $resp = new Response_delegate();
		    $resp->bind($response);
		    $resp->question_id = $question->id;
		    
		    $resp->store();
		    
		    if (false === empty($resp->id))
		    {
		        $response_ids[] = $resp->id;
		    }
		}
		
		if (0 < sizeof($response_ids))
		{
		    $query = 'DELETE FROM ' . $this->db->protect_identifiers('responses')
		    . ' WHERE question_id = ? AND id NOT IN (' . implode(',', $response_ids) . ')';
		    
		    $this->db->query($query, array($question->id));
		}
		
		redirect('admin/questions');
	}
	
	public function delete()
	{
		$cid = $this->input->post('cid');
		$cid = (true === is_array($cid)) ? $cid : array();
		
		if (0 < sizeof($cid))
		{
		    $query = 'DELETE FROM ' . $this->db->protect_identifiers('responses')
		    . ' WHERE question_id IN (' . implode(',', $cid) . ')';
		    
		    $this->db->query($query);
		    
			$query = 'DELETE FROM ' . $this->db->protect_identifiers('questions')
			. ' WHERE id IN (' . implode(',', $cid) . ')';
			
			$this->db->query($query);
		}
		
		redirect('admin/questions');
	}
}
?>