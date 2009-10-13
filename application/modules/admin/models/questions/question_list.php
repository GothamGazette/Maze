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

class Question_list extends Model
{
    private $_questions;
    private $_questioncount;
    private $_responsecount;

    public function Question_list()
    {
        parent::Model();
    }

    public function &getQuestions()
    {
        if (null === $this->_questions)
        {
            $this->_loadQuestions();
        }

        return $this->_questions;
    }

    private function _loadQuestions()
    {
        $limit_start = (int)$this->uri->segment(4);
		$limit_start = (false === empty($limit_start)) ? $limit_start : 0;

        $query = 'SELECT q.id, q.title, COUNT(r.id) AS responsecount'
        . ' FROM ' . $this->db->protect_identifiers('questions') . ' AS q'
        . ' LEFT OUTER JOIN ' . $this->db->protect_identifiers('responses') . ' AS r ON r.question_id = q.id'
        . ' GROUP BY q.id, q.title'
        . ' LIMIT ?,?';

        $rs = $this->db->query($query, array($limit_start, 20));
        $this->_questions = $rs->result();
    }

    public function getQuestionCount()
    {
        if (null === $this->_questioncount)
        {
            $this->_loadQuestionCount();
        }

        return $this->_questioncount;
    }

    private function _loadQuestionCount()
    {
        $query = 'SELECT COUNT(*) AS questioncount FROM ' . $this->db->protect_identifiers('questions');

        $rs = $this->db->query($query);
        $result = $rs->row();
        $this->_questioncount = $result->questioncount;
    }
}
?>