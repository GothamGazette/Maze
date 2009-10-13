<?php
class All_levels extends Model
{
	private $_levels;
	
	public function All_levels()
	{
		parent::Model();
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
	
	public function getQuestions($level)
	{
		$query = 'SELECT q.* FROM ' . $this->db->protect_identifiers('questions') . ' AS q'
		. ' INNER JOIN ' . $this->db->protect_identifiers('rooms') . ' AS r ON r.question_id = q.id'
		. ' WHERE r.level_id = ?';
		
		$rs = $this->db->query($query, array($level));
		return $rs->result();
	}
	
	public function getResponses($question)
	{
		$query = 'SELECT * FROM ' . $this->db->protect_identifiers('responses')
		. ' WHERE question_id = ?';
		
		$rs = $this->db->query($query, array($question));
		return $rs->result();
	}
}
?>