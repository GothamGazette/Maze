<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Maze
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

class Response_delegate extends Table_delegate
{
    public $id;
    public $question_id;
    public $title;
    public $response;
    public $more_information;
    public $image;
    public $image_hover;
    public $image_pos_x;
    public $image_pos_y;
    public $ordering;
    public $move_ahead;
    public $points_awarded;
    public $schedule_change;
    public $end_game_immediately;
    
    public function __construct($id = null)
    {
        parent::__construct('responses', 'id', $id);
    }
}
?>