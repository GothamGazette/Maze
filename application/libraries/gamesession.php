<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Libraries
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

define('GAME_SESSION_KEY', 'gameession');

class GameSession
{
    public $id;
    public $level_id;
    public $room;
    public $points;
    public $time_remaining;
    public $completedquestions = array();
    public $currentorientation;
    public $previousroom;
    
    function __construct()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        $ci->load->helper('object');
        $ci->load->helper('array');
        $ci->load->table('gamesession');
        
        $session = $ci->session->userdata(GAME_SESSION_KEY);

        if (false === empty($session))
        {
            ArrayHelper::bindArrayToObject($session, $this);
        }
        else
        {
            $this->id = 0;
            $this->completedquestions = array();
            $this->_refreshSession();
        }
        
        $this->_loadDBSession();
    }
    
    function __destruct()
    {
        $this->_refreshSession();
    }

    private function _refreshSession()
    {
        $ci = &get_instance();
        $ci->session->set_userdata(GAME_SESSION_KEY, ObjectHelper::toArray($this, false));
        
        $db_session = new Gamesession_delegate($this->id);
        ObjectHelper::shallowCopy($this, $db_session);
        $db_session->store();
        $this->id = $db_session->id;
    }

    private function _loadDBSession()
    {
        $db_session = new Gamesession_delegate($this->id);
        $db_session->load();

        if (true === empty($db_session->id))
        {
            ObjectHelper::shallowCopy($this, $db_session);
            $db_session->store();
            $this->id = $db_session->id;
            
            $this->_refreshSession();
        }
    }
    
    public function reset()
    {
        $this->id = 0;
        $this->level_id = 0;
        $this->room = 0;
        $this->completedquestions = array();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLevel()
    {
        return $this->level_id;
    }

    public function setLevel($level)
    {
        $this->level_id = $level;
    }

    public function getRoom()
    {
        return $this->room;
    }

    public function setRoom($room)
    {
        $this->previousroom = $this->room;
        $this->room = $room;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getTimeRemaining()
    {
        return $this->time_remaining;
    }

    public function setTimeRemaining($timeremaining)
    {
        $this->time_remaining = $timeremaining;
    }

    public function getCompletedQuestions()
    {
        return $this->completedquestions;
    }

    public function addCompletedQuestion($question_id)
    {
        $this->completedquestions[] = $question_id;
    }

    public function clearCompletedQuestions()
    {
        $this->completedquestions = array();
    }

    public function getCurrentOrientation()
    {
        return $this->currentorientation;
    }

    public function setCurrentOrientation($orientation)
    {
        $this->currentorientation = $orientation;
    }

    public function getPreviousRoom()
    {
        return $this->previousroom;
    }

    public function setPreviousRoom($room)
    {
        $this->previousroom = $room;
    }
}
?>
