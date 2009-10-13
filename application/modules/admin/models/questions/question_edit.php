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

class Question_edit extends Model
{
    private $_responses;
    private $_question_id;
    
    public function Question_edit()
    {
        parent::Model();
    }
    
    public function setId($id)
    {
        $this->_question_id = $id;
    }
    
    public function &getResponses()
    {
        if (null === $this->_responses)
        {
            $this->_loadResponses();
        }
        
        return $this->_responses;
    }
    
    private function _loadResponses()
    {
        $query = 'SELECT * FROM ' . $this->db->protect_identifiers('responses')
        . ' WHERE question_id = ?'
        . ' ORDER BY ordering';
        
        $rs = $this->db->query($query, array($this->_question_id));
        $this->_responses = $rs->result();
    }
}
?>