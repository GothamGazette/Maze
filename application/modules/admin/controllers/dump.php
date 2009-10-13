<?php
class Dump extends Controller
{
	public function Dump()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$this->load->model('dump/all_levels');
		
		$data = array();
		$data['levels'] = &$this->all_levels->getLevels();
		
		$this->load->view('header');
		$this->load->view('dump/dump', $data);
		$this->load->view('footer');
	}
}
?>