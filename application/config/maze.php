<?php
/**
 * @package		Gotham Gazette Budget Game
 * @subpackage	Config
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


$config['max_budget_days'] = 180;
$config['maze_width'] = 10;
$config['maze_height'] = 8;
$config['out_of_time_message'] = 'Whoops! Unfortunately, it looks like you were led astray one too many times. The July 1 budget deadline arrived before you could find your way through the maze.';
$config['end_game_immeditately_message'] = 'Sorry! Care to play again?';
$config['debug'] = false;
$config['image_magick_path'] = '/usr/bin';
?>
